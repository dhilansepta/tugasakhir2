<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriManagementController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'kategori' => ['required', 'string', 'max:255'],
        ]);

        Kategori::create([
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function viewKategori()
    {
        $kategori = Kategori::orderBy('id', 'asc')->get();
        return view('owner.kategoribarang', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, berikan response atau redirect dengan error
        if (!$kategori) {
            return redirect()->route('owner.kategoribarang')->with('error', 'Kategori tidak ditemukan.');
        }

        // Jika kategori ditemukan, tampilkan view edit dan kirim data kategori
        return view('owner.kategoribarang', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'kategori' => ['required', 'string', 'max:255', 'unique:kategori,kategori,'.$id],
        ]);
        
        $kategori->update([
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('owner.kategoribarang')->with('success', 'Kategori berhasil diperbarui');
    }
}
