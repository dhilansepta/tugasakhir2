<?php

use App\Http\Controllers\Karyawan\KaryawanController;
use App\Http\Controllers\Manage\BarangManagementController;
use App\Http\Controllers\Manage\KategoriManagementController;
use App\Http\Controllers\Manage\Select2Controller;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Manage\AccountManagementController;
use App\Http\Controllers\Manage\SatuanManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Laporan\StokBarangController;
use App\Http\Controllers\Laporan\PenjualanController;
use App\Http\Controllers\Manage\BarangKeluarManagementController;
use App\Http\Controllers\Manage\BarangMasukManagementController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Pdf\PDFController;
use App\Http\Controllers\Manage\ReturBarangManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');


Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
})->middleware(['auth', 'verified'])->name('owner.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Manage Store
Route::post('store-barangkeluar', [BarangKeluarManagementController::class, 'store'])->name('manage.store-barangkeluar');
Route::post('store-account', [AccountManagementController::class, 'store'])->name('manage.store-account');
Route::post('store-satuan', [SatuanManagementController::class, 'store'])->name('manage.store-satuan');
Route::post('store-kategori', [KategoriManagementController::class, 'store'])->name('manage.store-kategori');
Route::post('store-barang', [BarangManagementController::class, 'store'])->name('manage.store-barang');
Route::post('store-barangmasuk', [BarangMasukManagementController::class, 'store'])->name('manage.store-barangmasuk');
Route::post('store-returbarang', [ReturBarangManagementController::class, 'store'])->name('manage.store-returbarang');

//Manage Edit
Route::put('edit-barangkeluar/{id}', [BarangKeluarManagementController::class, 'update'])->name('manage.update-barangkeluar');
Route::put('edit-kelolaakun/{id}', [AccountManagementController::class, 'update'])->name('manage.update-account');
Route::put('edit-satuanbarang/{id}', [SatuanManagementController::class, 'update'])->name('manage.update-satuan');
Route::put('edit-kategoribarang/{id}', [KategoriManagementController::class, 'update'])->name('manage.update-kategori');
Route::put('edit-daftarbarang/{id}', [BarangManagementController::class, 'update'])->name('manage.update-barang');
Route::put('edit-stokbarang/{id}', [StokBarangController::class, 'update'])->name('laporan.update-stok');
Route::put('edit-barangmasuk/{id}', [BarangMasukManagementController::class, 'update'])->name('manage.update-barangmasuk');
Route::put('edit-barangkeluar/{id}', [BarangKeluarManagementController::class, 'update'])->name('manage.update-barangkeluar');
Route::put('edit-returbarang/{id}', [ReturBarangManagementController::class, 'update'])->name('manage.update-returbarang');

//Manage Delete
Route::delete('delete-barangkeluar/{id}', [BarangKeluarManagementController::class, 'destroy'])->name('manage.delete-barangkeluar');
Route::delete('delete-barangmasuks/{id}', [BarangMasukManagementController::class, 'destroy'])->name('manage.delete-barangmasuk');
Route::delete('delete-returbarang/{id}', [ReturBarangManagementController::class, 'destroy'])->name('manage.delete-returbarang');
Route::delete('delete-daftarbarang/{id}', [BarangManagementController::class, 'destroy'])->name('manage.delete-daftarbarang');

//Select 2 Controller
Route::get('selectbarang', [Select2Controller::class, 'selectBarang'])->name('selectbarang');
Route::get('selectbarang/{id}', [Select2Controller::class, 'getData']);

//Download
Route::get('/downloadLaporanPenjualan-pdf', [PDFController::class, 'downloadLaporanPenjualan'])->name('downloadLaporanPenjualan');
Route::get('/downloadLaporanStok-pdf', [PDFController::class, 'downloadLaporanStok'])->name('downloadLaporanStok');


Route::get('/viewLaporan', [PDFController::class, 'viewLaporan'])->name('pdf.laporanPenjualan');

Route::get('/data-dashboard', [DashboardController::class, 'getData']);

//Karyawan Routes
Route::middleware(['auth', 'karyawanMiddleware'])->group(function () {
    //Halaman
    Route::get('/karyawan/barangkeluar', [KaryawanController::class, 'barangKeluar'])->name('karyawan.barangkeluar');

    //Manage Data View
    Route::get('karyawan/barangkeluar', [BarangKeluarManagementController::class, 'viewBarangKeluar'])->name('karyawan.barangkeluar');
});

//Owner Routes
Route::middleware(['auth', 'ownerMiddleware'])->group(function () {
    //Halaman
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/barangmasuk', [OwnerController::class, 'barangMasuk'])->name('owner.barangmasuk');
    Route::get('/owner/daftarbarang', [OwnerController::class, 'daftarBarang'])->name('owner.daftarbarang');
    Route::get('/owner/kategoribarang', [OwnerController::class, 'kategoriBarang'])->name('owner.kategoribarang');
    Route::get('/owner/kelolaakun', [OwnerController::class, 'kelolaAkun'])->name('owner.kelolaakun');
    Route::get('/owner/penjualan', [OwnerController::class, 'penjualan'])->name('owner.penjualan');
    Route::get('/owner/satuanbarang', [OwnerController::class, 'satuanBarang'])->name('owner.satuanbarang');
    Route::get('/owner/barangkeluar', [OwnerController::class, 'barangKeluar'])->name('owner.barangkeluar');
    Route::get('/owner/stokbarang', [OwnerController::class, 'stokBarang'])->name('owner.stokbarang');

    //Manage Data View
    Route::get('owner/kelolaakun', [AccountManagementController::class, 'viewAkun'])->name('owner.kelolaakun');
    Route::get('owner/satuanbarang', [SatuanManagementController::class, 'viewSatuan'])->name('owner.satuanbarang');
    Route::get('owner/kategoribarang', [KategoriManagementController::class, 'viewKategori'])->name('owner.kategoribarang');
    Route::get('owner/daftarbarang', [BarangManagementController::class, 'viewBarang'])->name('owner.daftarbarang');
    Route::get('owner/barangkeluar', [BarangKeluarManagementController::class, 'viewBarangKeluar'])->name('owner.barangkeluar');
    Route::get('owner/barangmasuk', [BarangMasukManagementController::class, 'viewBarangMasuk'])->name('owner.barangmasuk');
    Route::get('owner/stokbarang', [StokBarangController::class, 'viewLaporanStok'])->name('owner.stokbarang');
    Route::get('owner/penjualan', [PenjualanController::class, 'viewLaporanPenjualan'])->name('owner.penjualan');
    Route::get('owner/dashboard', [DashboardController::class, 'viewData'])->name('owner.dashboard');
    Route::get('owner/returbarang', [ReturBarangManagementController::class, 'viewData'])->name('owner.returbarang');

    //Get Data untuk Dashboard

});
