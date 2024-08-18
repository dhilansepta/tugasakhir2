<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index(){
        return view('owner.dashboard');
    }
    public function barangKeluar(){
        return view('owner.barangkeluar');
    }
    public function barangMasuk(){
        return view('owner.barangmasuk');
    }
    public function daftarBarang(){
        return view('owner.daftarbarang');
    }
    public function kategoriBarang(){
        return view('owner.kategoribarang');
    }
    public function kelolaAkun(){
        return view('owner.kelolaakun');
    }
    public function penjualan(){
        return view('owner.penjualan');
    }
    public function satuanBarang(){
        return view('owner.satuanbarang');
    }
    public function stokBarang(){
        return view('owner.stokbarang');
    }
}
