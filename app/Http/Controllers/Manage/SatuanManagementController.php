<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanManagementController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'satuan' => ['required', 'string', 'max:255'],
        ]);

        Satuan::create([
            'satuan' => $request->satuan,
        ]);
        
        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function viewSatuan(Request $request)
    {
        $filterSearch = $request->input('filterSearch');

        $satuanQuery = Satuan::query();

        if ($filterSearch) {
            $satuanQuery->where('satuan', 'like', '%' . $filterSearch . '%');
        }

        $satuan = $satuanQuery->orderBy('id', 'asc')->paginate(10)->appends($request->all());
        return view('owner.satuanbarang', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        $request->validate([
            'satuan' => ['required', 'string', 'max:255', 'unique:satuan,satuan,'.$id],
        ]);
        
        $satuan->update([
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('owner.satuanbarang')->with('success', 'Satuan berhasil diperbarui');
    }
}
