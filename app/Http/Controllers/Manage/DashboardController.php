<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStokBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function viewData(Request $request)
    {
        $today = Carbon::today();

        $totalKaryawan = DB::table('users')
            ->where('role', 'karyawan')
            ->count();

        $pendapatanKotor = DB::table('laporanpenjualan')
            ->whereDate('created_at', $today)
            ->sum('pendapatan_kotor');

        $pendapatanSebenarnya = DB::table('laporanpenjualan')
            ->whereDate('created_at', $today)
            ->sum('pendapatan_sebenarnya');

        $pendapatanBersih = DB::table('laporanpenjualan')
            ->whereDate('created_at', $today)
            ->sum('keuntungan');

        return view('owner.dashboard', compact('totalKaryawan', 'pendapatanKotor', 'pendapatanSebenarnya', 'pendapatanBersih'));
    }

    public function getData(Request $request)
    {
        $barangTelur = Barang::where('nama_barang', 'Telur')->first();
        $barangIdTelur = $barangTelur->id;
        $unit = $request->input('unit');

        $datastokTelur = LaporanStokBarang::where('barang_id', $barangIdTelur)
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(stok_keluar) as stok_keluar'), DB::raw('SUM(stok_akhir) as stok_akhir'))
            ->groupBy(DB::raw('tanggal'))
            ->orderBy(DB::raw('tanggal'))
            ->get();

        $labelsStok = $datastokTelur->pluck('tanggal');
        $stokKeluar = $datastokTelur->pluck('stok_keluar');
        $sisaStok = $datastokTelur->pluck('stok_akhir')->map(function($stok) use($unit){
            if($unit == 'peti'){
                return $stok / 15;
            }
            return $stok;
        });

        $dataPenjualan = DB::table('laporanpenjualan')
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(pendapatan_kotor) as pendapatan_kotor'),
                DB::raw('SUM(pendapatan_sebenarnya) as pendapatan_sebenarnya'),
                DB::raw('SUM(keuntungan) as pendapatan_bersih'),
            )
            ->groupBy(DB::raw('tanggal'))
            ->orderBy(DB::raw('tanggal'))
            ->get();

        $labelsPenjualan = $dataPenjualan->pluck('tanggal');
        $pendapatanKotor = $dataPenjualan->pluck('pendapatan_kotor');
        $pendapatanSebenarnya = $dataPenjualan->pluck('pendapatan_sebenarnya');
        $pendapatanBersih = $dataPenjualan->pluck('pendapatan_bersih');

        return response()->json([
            'labelsStok' => $labelsStok,
            'stokKeluar' => $stokKeluar,
            'sisaStok' => $sisaStok,

            'labelsPenjualan' => $labelsPenjualan,
            'pendapatanKotor' => $pendapatanKotor,
            'pendapatanSebenarnya' => $pendapatanSebenarnya,
            'pendapatanBersih' => $pendapatanBersih
            
        ]);
    }
}
