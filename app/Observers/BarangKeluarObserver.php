<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStokBarang;
use Illuminate\Support\Facades\Log;

class BarangKeluarObserver
{
    /**
     * Handle the BarangKeluar "created" event.
     */
    public function created(BarangKeluar $barangKeluar): void
    {
        // Ambil data barang dan laporan stok
        $barangId = $barangKeluar->barang_id;
        $barang = Barang::find($barangId);

        $laporanStok = LaporanStokBarang::where('barang_id', $barangId)
            ->orderBy('created_at', 'desc')
            ->first();

        $laporanStokId = $laporanStok->id;

        //Update sisa stok untuk data barang
        $barang->stok -= $barangKeluar->jumlahKeluar;

        // Update stok keluar dan stok akhir
        $laporanStok->stok_keluar += $barangKeluar->jumlahKeluar;
        $laporanStok->stok_akhir = ($laporanStok->stok_awal + $laporanStok->stok_masuk) - $laporanStok->stok_keluar;
        $laporanStok->stok_minus = $laporanStok->stok_akhir - $laporanStok->stok_gudang;

        $laporanPenjualan = LaporanPenjualan::where('laporan_id', $laporanStokId)
            ->orderBy('created_at', 'desc')
            ->first();

        $laporanPenjualan->pendapatan_kotor = $barang->harga_jual * $laporanStok->stok_keluar;
        $laporanPenjualan->kerugian = $barang->harga_jual * $laporanStok->stok_minus;
        $laporanPenjualan->pendapatan_sebenarnya = $laporanPenjualan->pendapatan_kotor - $laporanPenjualan->kerugian;
        
        $barang->save();
        $laporanStok->save();
        $laporanPenjualan->save();

    }

    /**
     * Handle the BarangKeluar "updated" event.
     */
    public function updated(BarangKeluar $barangKeluar): void
    {
        //Hitung Apakah ada penambahan stok atau tidak
        $stokDiff = $barangKeluar->jumlahKeluar - $barangKeluar->getOriginal('jumlahKeluar');

        //Get data barang sebelum update
        $oldBarangId = $barangKeluar->getOriginal('barang_id');
        $oldBarang = Barang::find($oldBarangId);

        $oldLaporanStok = LaporanStokBarang::where('barang_id', $oldBarangId)
            ->orderBy('created_at', 'desc')
            ->first();

        //Get data barang yang diupdate
        $newBarangId = $barangKeluar->barang_id;
        $newBarang = Barang::find($newBarangId);

        $newLaporanStok = LaporanStokBarang::where('barang_id', $newBarangId)
            ->orderBy('created_at', 'desc')
            ->first();

        //Jika Barang Berubah
        if ($oldBarangId != $newBarangId) {
            //Tambah sisa stok barang pada data barang lama dan stok keluar dan stok akhir pada laporan stok barang lama
            if ($oldLaporanStok) {
                $oldBarang->stok += $barangKeluar->getOriginal('jumlahKeluar');

                $oldLaporanStok->stok_keluar -= $barangKeluar->getOriginal('jumlahKeluar');
                $oldLaporanStok->stok_akhir += $barangKeluar->getOriginal('jumlahKeluar');
                $newLaporanStok->stok_minus = $oldLaporanStok->stok_akhir + $oldLaporanStok->stok_gudang;
                $oldBarang->save();
                Log::info("Data Barang Lama berhasil ditambah");
                $oldLaporanStok->save();
                Log::info("Data Laporan Stok Lama berhasil ditambah");
            }
            //Kurangi sisa stok barang pada data barang baru dan stok keluar dan stok akhir pada laporan stok barang baru
            if ($newLaporanStok) {
                $newBarang->stok -= $barangKeluar->jumlahKeluar;

                $newLaporanStok->stok_keluar += $barangKeluar->jumlahKeluar;
                $newLaporanStok->stok_akhir -= $barangKeluar->jumlahKeluar;
                $newLaporanStok->stok_minus = $newLaporanStok->stok_akhir - $newLaporanStok->stok_gudang;

                $newBarang->save();
                Log::info("Data barang baru berhasil dikurang");
                $newLaporanStok->save();
                Log::info("Data laporan stok baru berhasil dikurang");
            }
        }
        //Jika Barang tidak berubah
        else if ($oldBarangId == $newBarangId) {
            //Jumlahkan sisa stok data barang lama dengan stok diff dan Hitung stok keluar dan stok akhir pada laporan stok
            if ($newLaporanStok) {
                $newBarang->stok -= $stokDiff;

                $newLaporanStok->stok_keluar += $stokDiff;
                $newLaporanStok->stok_akhir = ($newLaporanStok->stok_awal + $newLaporanStok->stok_masuk) - $newLaporanStok->stok_keluar;
                $newLaporanStok->stok_minus = $newLaporanStok->stok_akhir - $newLaporanStok->stok_gudang;
                $newBarang->save();
                $newLaporanStok->save();
                Log::warning("berhasil update stok keluar dan stok akhir berdasarkan perbedaan jumlah");
            }
        }
    }

    /**
     * Handle the BarangKeluar "deleted" event.
     */
    public function deleted(BarangKeluar $barangKeluar): void
    {
        // Ambil data barang dan laporan stok
        $barangId = $barangKeluar->barang_id;
        $barang = Barang::find($barangId);

        $laporanStok = LaporanStokBarang::where('barang_id', $barangKeluar->barang_id)
            ->orderBy('created_at', 'desc')
            ->first();

        //Update sisa stok untuk data barang
        $barang->stok += $barangKeluar->jumlahKeluar;

        // Update stok keluar dan stok akhir
        $laporanStok->stok_keluar -= $barangKeluar->jumlahKeluar;
        $laporanStok->stok_akhir = ($laporanStok->stok_awal + $laporanStok->stok_masuk) - $laporanStok->stok_keluar;

        $barang->save();
        $laporanStok->save();
    }

    /**
     * Handle the BarangKeluar "restored" event.
     */
    public function restored(BarangKeluar $barangKeluar): void
    {
        //
    }

    /**
     * Handle the BarangKeluar "force deleted" event.
     */
    public function forceDeleted(BarangKeluar $barangKeluar): void
    {
        //
    }
}
