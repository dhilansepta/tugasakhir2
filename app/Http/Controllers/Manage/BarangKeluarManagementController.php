<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarManagementController extends Controller
{
    public function store(Request $request)
    {
        $barang = Barang::find($request->barang_id);

        $stok = $barang->stok;
        
        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'karyawan_id' => ['required', 'exists:users,id'],
            'jumlahKeluar' =>
            [
                'required',
                'integer',
                'max:255',
                function ($attribute, $value, $fail) use ($stok) {
                    if ($value > $stok) {
                        $fail("Jumlah keluar tidak boleh melebihi stok saat ini ($stok).");
                    }
                },
            ],
        ]);

        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'karyawan_id' => $request->karyawan_id,
            'jumlahKeluar' => $request->jumlahKeluar,
        ]);

        return redirect()->back()->with('success', 'Data berhasil dibuat');
    }

    public function viewBarangKeluar(Request $request)
    {
        $filterTanggal = $request->input('filterTanggal');
        $filterSearch = $request->input('filterSearch');

        $today = Carbon::today();
        $barang = Barang::all();
        $karyawan = User::all();
        $barangKeluarQuery = BarangKeluar::query();

        if (!$filterTanggal) {
            $barangKeluarQuery->whereDate('created_at', $today);
        } else {
            $barangKeluarQuery->whereDate('created_at', $filterTanggal);
        }

        if ($filterSearch) {
            $barangKeluarQuery->where(function ($query) use ($filterSearch) {
                $query->whereHas(
                    'barang',
                    function ($q) use ($filterSearch) {
                        $q->where('nama_barang', 'like', '%' . $filterSearch . '%');
                    }
                )->orWhereHas(
                    'users',
                    function ($q) use ($filterSearch) {
                        $q->where('name', 'like', '%' . $filterSearch . '%');
                    }
                )->orWhereHas('barang', function ($q) use ($filterSearch) {
                    $q->whereHas('kategori', function ($qu) use ($filterSearch) {
                        $qu->where('kategori', 'like', '%' . $filterSearch . '%');
                    });
                });
            });
        }

        if (Auth::user()->role == 'Owner') {
            $barangkeluar = $barangKeluarQuery->orderBy('id', 'asc')->get();
            perPage:
            return view('owner.barangkeluar', compact('barang', 'karyawan', 'barangkeluar'));
        } elseif (Auth::user()->role == 'Karyawan') {
            $barangKeluarQuery->where('karyawan_id', Auth::user()->id);
            $barangkeluar = $barangKeluarQuery->orderBy('id', 'asc')->get();
            return view('karyawan.barangkeluar', compact('barang', 'barangkeluar'));
        }
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'karyawan_id' => ['required', 'exists:users,id'],
            'jumlahKeluar' => ['required', 'integer', 'min:0'],
        ]);

        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'karyawan_id' => $request->karyawan_id,
            'jumlahKeluar' => $request->jumlahKeluar,
        ]);

        if (Auth::user()->role == 'Owner') {
            return redirect()->route('owner.barangkeluar')->with('success', 'Data Barang berhasil diperbarui');
        } elseif (Auth::user()->role == 'Karyawan') {
            return redirect()->route('karyawan.barangkeluar')->with('success', 'Data Barang berhasil diperbarui');
        }
    }

    public function destroy($id)
    {
        // Cari data barangmasuk berdasarkan ID
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barangKeluar->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Barang Keluar berhasil dihapus dan stok telah diperbarui.');
    }
}
