<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\LaporanPenjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function viewLaporanPenjualan(Request $request)
    {
        $filterTanggal = $request->input('filterTanggal');
        $filterSearch = $request->input('filterSearch');

        $today = Carbon::today();
        $laporanPenjualanQuery = LaporanPenjualan::query();

        if (!$filterTanggal) {
            $laporanPenjualanQuery->whereDate('created_at', $today);
            session(['tanggal' => $today]);
        } else {
            $laporanPenjualanQuery->whereDate('created_at', $filterTanggal);
            session(['tanggal' => $filterTanggal]);
        }

        if ($filterSearch) {
            $laporanPenjualanQuery->where(function ($query) use ($filterSearch) {
                $query->whereHas('laporanstok',function ($q) use ($filterSearch) {
                        $q->whereHas('barang', function($qu) use ($filterSearch){
                            $qu->where('nama_barang', 'like', '%' . $filterSearch . '%')
                            ->orWhere('id', 'like', '%' . $filterSearch . '%');
                        });
                    }
                );
            });
        }

        $laporanPenjualan = $laporanPenjualanQuery->orderBy('id', 'asc')->get();

        session(['laporanPenjualan' => $laporanPenjualan]);
        return view('owner.penjualan', compact( 'laporanPenjualan'));
    }
}