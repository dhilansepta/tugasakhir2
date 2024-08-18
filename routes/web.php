<?php

use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Karyawan Routes
Route::middleware(['auth','karyawanMiddleware'])->group(function(){
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
    //Route::get('/karyawan/barangkeluar', [KaryawanController::class, 'barangKeluar'])->name('karyawan.barangkeluar');
});

//Owner Routes
Route::middleware(['auth','ownerMiddleware'])->group(function(){
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    //Route::get('/owner/barangmasuk', [OwnerController::class, 'barangMasuk'])->name('owner.barangmasuk');
    //Route::get('/owner/daftarbarang', [OwnerController::class, 'daftarBarang'])->name('owner.daftarbarang');
    //Route::get('/owner/kategoribarang', [OwnerController::class, 'kategoriBarang'])->name('owner.kategoribarang');
    //Route::get('/owner/kelolaakun', [OwnerController::class, 'kelolaAkun'])->name('owner.kelolaakun');
    //Route::get('/owner/penjualan', [OwnerController::class, 'penjualan'])->name('owner.penjualan');
    //Route::get('/owner/satuanbarang', [OwnerController::class, 'satuanBarang'])->name('owner.satuanbarang');
    //Route::get('/owner/barangkeluar', [OwnerController::class, 'barangKeluar'])->name('owner.barangkeluar');
    //Route::get('/owner/stokbarang', [OwnerController::class, 'stokBarang'])->name('owner.stokbarang');
});