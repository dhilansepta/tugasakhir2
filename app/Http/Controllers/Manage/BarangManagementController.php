<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangManagementController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'satuan_id' => ['required', 'exists:satuan,id'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'harga_jual' => ['required', 'integer', 'min:0'],
            'keuntungan' => ['nullable', 'integer', 'min:0'],
            'stok' => ['nullable', 'integer', 'min:0'],
            'barcode' => ['required', 'string', 'unique:barang,barcode'],
        ]);

        $keuntungan = $request->keuntungan ?? ($request->harga_jual - $request->harga_beli);

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'satuan_id' => $request->satuan_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'keuntungan' => $keuntungan,
            'stok' => $request->stok ?? 0,
            'barcode' => $request->barcode,
        ]);
        
        
        $barang->save();

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function viewBarang(Request $request)
    {
        $filterSearch = $request->input('filterSearch');
        $sortBy = $request->input('sort_by');

        $barangQuery = Barang::query();

        if ($filterSearch) {
            $barangQuery->where('nama_barang', 'like', '%' . $filterSearch . '%')
                ->orWhereHas('kategori', function ($q) use ($filterSearch) {
                    $q->where('kategori', 'like', '%' . $filterSearch . '%');
                });
        }

        if ($sortBy) {
            $barang = $barangQuery->orderBy($sortBy, 'asc')->get();
        }

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        $barang = $barangQuery->orderBy('id', 'asc')->get();
        return view('owner.daftarbarang', compact('barang', 'kategori', 'satuan'));
    }

    public function edit($id)
    {
        $barang = Barang::find($id);

        // Jika kategori tidak ditemukan, berikan response atau redirect dengan error
        if (!$barang) {
            return redirect()->route('owner.barangmasuk')->with('error', 'Data Barang tidak ditemukan.');
        }

        // Jika kategori ditemukan, tampilkan view edit dan kirim data kategori
        return view('owner.barangmasuk', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => ['required', 'string', 'max:255', 'unique:barang,nama_barang,' . $id],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'satuan_id' => ['required', 'exists:satuan,id'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'harga_jual' => ['required', 'integer', 'min:0'],
            'keuntungan' => ['nullable', 'integer', 'min:0'],
            'barcode' => ['required', 'string', 'unique:barang,barcode,' . $id],
        ]);

        $keuntungan = $request->keuntungan ?? ($request->harga_jual - $request->harga_beli);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'satuan_id' => $request->satuan_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'keuntungan' => $keuntungan,
            'barcode' => $request->barcode,
        ]);

        return redirect()->route('owner.daftarbarang')->with('success', 'Data Barang berhasil diperbarui');
    }
}
