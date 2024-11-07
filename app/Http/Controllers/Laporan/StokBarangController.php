<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\LaporanStokBarang;
use App\Models\ReturBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    public function viewLaporanStok(Request $request)
    {
        $filterTanggal = $request->input('filterTanggal');
        $filterSearch = $request->input('filterSearch');

        $today = Carbon::today();
        $laporanStokQuery = LaporanStokBarang::query();

        if (!$filterTanggal) {
            $laporanStokQuery->whereDate('created_at', $today);
            session(['tanggal' => $today]);
        } else {
            $laporanStokQuery->whereDate('created_at', $filterTanggal);
            session(['tanggal' => $filterTanggal]);
        }

        if ($filterSearch) {
            $laporanStokQuery->where(function ($query) use ($filterSearch) {
                $query->whereHas('barang', function ($q) use ($filterSearch) {
                    $q->where('nama_barang', 'like', '%' . $filterSearch . '%');
                });
            });
        }


        $totalRetur = DB::table('retur_barang')
            ->select('barang_id', DB::raw('SUM(jumlah) as total_retur'))
            ->whereIn('status', ['expired', 'rusak'])
            ->groupBy('barang_id')
            ->pluck('total_retur', 'barang_id');

        $laporanStok = $laporanStokQuery->orderBy('id', 'asc')->get();
        session(['laporanStok' => $laporanStok]);
        return view('owner.stokbarang', compact('laporanStok', 'totalRetur'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanStokBarang::findOrFail($id);

        $request->validate([
            'stok_gudang' => ['required', 'integer', 'min:0'],
        ]);

        $barangId = $laporan->barang_id;

        $totalBarangRetur = DB::table('retur_barang')
            ->where('barang_id', $barangId)
            ->whereIn('status', ['expired', 'rusak'])
            ->sum('jumlah');

        $totalStokGudang = $request->stok_gudang + $totalBarangRetur;

        $laporan->update([
            'stok_gudang' => $totalStokGudang,
            'stok_minus' => $totalStokGudang - $laporan->stok_akhir
        ]);

        return redirect()->route('owner.stokbarang')->with('success', 'Data berhasil diperbarui');
    }
}
