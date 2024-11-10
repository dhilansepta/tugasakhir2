<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ]);

        $keuntungan = $request->keuntungan ?? ($request->harga_jual - $request->harga_beli);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'satuan_id' => $request->satuan_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'keuntungan' => $keuntungan,
        ]);
        
        $dataHargaBeliVersion = [
            'updated_at' => now(),
            'harga_persatuan' => $barang->harga_beli, 
        ];
        
        // Update the latest record for the specific `barang_id`
        DB::table('harga_beli_version')
            ->where('barang_id', $barang->id)
            ->update($dataHargaBeliVersion);

        return redirect()->route('owner.daftarbarang')->with('success', 'Data Barang berhasil diperbarui');
    }

    public function destroy($id){
        $barang = Barang::findOrFail($id);

        $barang->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Barang berhasil dihapus dan stok telah diperbarui.');
    }
}
