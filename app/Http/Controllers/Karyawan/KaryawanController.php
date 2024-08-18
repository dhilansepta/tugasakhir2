<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(){
        return view('karyawan.dashboard');
    }

    public function barangKeluar(){
        return view('karyawan.barangkeluar');
    }
}
