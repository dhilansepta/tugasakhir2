<?php


namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ReturBarang;
use Illuminate\Http\Request;

class ReturBarangManagementController extends Controller
{
    public function viewData(Request $request)
    {
        $filterSearch = $request->input('filterSearch');
        $filterShow = $request->input('filterShow');

        $barang = Barang::all();
        $returBarangQuery = ReturBarang::query();

        if ($filterShow) {
            $returBarangQuery->where('status', $filterShow);
        }

        if ($filterSearch) {
            $returBarangQuery->where(function ($query) use ($filterSearch) {
                $query->whereHas(
                    'barang',
                    function ($q) use ($filterSearch) {
                        $q->where('nama_barang', 'like', '%' . $filterSearch . '%');
                    }
                )->orWhereHas('barang', function ($q) use ($filterSearch) {
                    $q->whereHas('kategori', function ($qu) use ($filterSearch) {
                        $qu->where('kategori', 'like', '%' . $filterSearch . '%');
                    });
                });
            });
        }

        $returBarang = $returBarangQuery->orderBy('updated_at', 'desc')->get();
        return view('owner.returbarang', compact('returBarang', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'jumlah' => ['required', 'integer', 'max:255'],
            'status' => ['required', 'string', 'in:expired,rusak,dikembalikan'],
        ]);

        ReturBarang::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $returBarang = ReturBarang::findOrFail($id);

        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'jumlah' => ['required', 'integer', 'max:255'],
            'status' => ['required', 'string', 'in:expired,rusak,dikembalikan'],
        ]);

        $returBarang->update([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
        ]);

        return redirect()->route('owner.returbarang')->with('success', 'Data Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cari data barangmasuk berdasarkan ID
        $returBarang = ReturBarang::findOrFail($id);

        $returBarang->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Barang Keluar berhasil dihapus dan stok telah diperbarui.');
    }
}
