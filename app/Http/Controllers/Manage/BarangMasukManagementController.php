<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangMasukManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'harga_persatuan' => ['nullable', 'integer', 'min:0'],
        ]);

        $harga_persatuan = $request->harga_persatuan ?? ($request->harga_beli / $request->jumlah);

        BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'harga_beli' => $request->harga_beli,
            'jumlah' => $request->jumlah,
            'harga_persatuan' => $harga_persatuan,
        ]);

        $barang = Barang::find($request->barang_id);

        //menambahkan stok
        $barang->stok += $request->jumlah;

        $barang->save();

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function viewBarangMasuk(Request $request)
    {
        $filterTanggal = $request->input('filterTanggal');
        $filterSearch = $request->input('filterSearch');

        $today = Carbon::today();
        $barang = Barang::all();
        $barangMasukQuery = BarangMasuk::query();

        if (!$filterTanggal) {
            $barangMasukQuery->whereDate('created_at', $today);
        } else {
            $barangMasukQuery->whereDate('created_at', $filterTanggal);
        }

        if ($filterSearch) {
            $barangMasukQuery->where(function($query) use($filterSearch){
                $query->whereHas('barang', function($q) use($filterSearch){
                    $q->where('nama_barang', 'like', '%' . $filterSearch . '%');
                }
                )->orWhereHas('barang', function($q) use($filterSearch){
                    $q->whereHas('kategori', function($qu) use($filterSearch){
                        $qu->where('kategori', 'like', '%' . $filterSearch . '%');
                    });
                });
            });
        }

        $barangmasuk = $barangMasukQuery->orderBy('id', 'asc')->get();
        return view('owner.barangmasuk', compact('barang', 'barangmasuk'));
    }

    public function edit($id)
    {
        // Find the barangmasuk record by its ID
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Get all barang data
        $barang = Barang::all();

        // Set the selected barang ID
        $selectedBarangId = $barangMasuk->barang_id; // Assuming barang_id is the foreign key in barangmasuk

        // dd($selectedBarangId,$barang);

        // Pass data to the view
        return view('layouts.partials.modaledit.barangmasuk', compact('barangMasuk', 'barang', 'selectedBarangId'));
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'harga_persatuan' => ['nullable', 'integer', 'min:0'],
        ]);

        $harga_persatuan = $request->harga_persatuan ?? ($request->harga_beli / $request->jumlah);

        $barangMasuk->update([
            'barang_id' => $request->barang_id,
            'harga_beli' => $request->harga_beli,
            'jumlah' => $request->jumlah,
            'harga_persatuan' => $harga_persatuan,
        ]);

        return redirect()->route('owner.barangmasuk')->with('success', 'Data Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cari data barangmasuk berdasarkan ID
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barangMasuk->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Barang Masuk berhasil dihapus dan stok telah diperbarui.');
    }
}
