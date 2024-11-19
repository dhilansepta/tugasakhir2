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

    public function viewKategori(Request $request)
    {
        $filterSearch = $request->input('filterSearch');

        $kategoriQuery = Kategori::query();

        if ($filterSearch) {
            $kategoriQuery->where('kategori', 'like', '%' . $filterSearch . '%');
        }

        $kategori = $kategoriQuery->orderBy('id', 'asc')->paginate(10)->appends($request->all());
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
