<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStokBarang;
use Illuminate\Support\Facades\DB;

class BarangObserver
{
    /**
     * Handle the Barang "created" event.
     */
    public function created(Barang $barang): void
    {
        //Create laporan stok barang untuk barang baru
        $barangId = $barang->id;
        $barang = Barang::find($barangId);

        $stokMasuk = 0;
        $stokKeluar = 0;
        $stokAkhir = $barang->stok + $stokMasuk - $stokKeluar;
        $stokGudang = 0;
        $stokMinus = 0;

        $dataLaporanStok = [
            'created_at' => now(),
            'updated_at' => now(),
            'barang_id' => $barang->id, // Menggunakan ID barang dari model
            'stok_awal' => $barang->stok,
            'stok_masuk' => $stokMasuk,
            'stok_keluar' => $stokKeluar,
            'stok_akhir' => $stokAkhir,
            'stok_gudang' => $stokGudang,
            'stok_minus' => $stokMinus
        ];
        $laporanStokId = DB::table('laporanstokbarang')->insertGetId($dataLaporanStok);

        //Create laporan penjualan barang untuk barang baru
        $laporanStokBarang = LaporanStokBarang::find($laporanStokId);

        $barangId = $laporanStokBarang->barang_id;
        $barang = Barang::find($barangId);

        $hargaJual = $barang->harga_jual;
        $keuntungan_persatuan = $barang->keuntungan;
        
        $keuntungan = $keuntungan_persatuan * $laporanStokBarang->stok_keluar;
        $pendapatan_kotor = $hargaJual * $laporanStokBarang->stok_keluar;
        $kerugian = abs($hargaJual * $laporanStokBarang->stok_minus);
        $pendapatan_sebenarnya = $pendapatan_kotor - $kerugian;

        $dataLaporanPenjualan = [
            'created_at' => now(),
            'updated_at' => now(),
            'laporan_id' => $laporanStokId,
            'harga_jual' => $hargaJual,
            'keuntungan_persatuan' => $keuntungan_persatuan,
            'keuntungan' => $keuntungan,
            'pendapatan_kotor' => $pendapatan_kotor,
            'kerugian' => $kerugian,
            'pendapatan_sebenarnya' => $pendapatan_sebenarnya,
        ];
        DB::table('laporanpenjualan')->insert($dataLaporanPenjualan);
        $barang->save();
        $laporanStokBarang->save();
    }

    /**
     * Handle the Barang "updated" event.
     */
    public function updated(Barang $barang): void
    {
        //Jika update harga jual barang, maka update laporan penjualan
        
    }

    /**
     * Handle the Barang "deleted" event.
     */
    public function deleted(Barang $barang): void
    {
        //
    }

    /**
     * Handle the Barang "restored" event.
     */
    public function restored(Barang $barang): void
    {
        //
    }

    /**
     * Handle the Barang "force deleted" event.
     */
    public function forceDeleted(Barang $barang): void
    {
        //
    }
}
