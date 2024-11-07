<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\LaporanPenjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function viewData(Request $request){
        $laporanPenjualan = LaporanPenjualan::all();
        $user = User::all();
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

        return view('owner.dashboard', compact('totalKaryawan', 'pendapatanKotor', 'pendapatanSebenarnya'));
    }
}
