<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\LaporanPenjualan;
use App\Models\LaporanStokBarang;
use Illuminate\Support\Facades\DB;

class LaporanStokObserver
{
    /**
     * Handle the LaporanStokBarang "created" event.
     */
    public function created(LaporanStokBarang $laporanStokBarang): void
    {
        //
    }

    /**
     * Handle the LaporanStokBarang "updated" event.
     */
    public function updated(LaporanStokBarang $laporanStokBarang): void
    {
        // $stokDiff = $laporanStokBarang->stok_gudang - $laporanStokBarang->getOriginal('stok_gudang');

        $barangId = $laporanStokBarang->barang_id;
        $barang = Barang::find($barangId);

        $laporanPenjualan = LaporanPenjualan::where('laporan_id', $laporanStokBarang->id)
        ->orderBy('created_at', 'desc')
        ->first();

        $laporanPenjualan->harga_jual = $barang->harga_jual;
        $laporanPenjualan->keuntungan_persatuan = $barang->keuntungan;

        $laporanPenjualan->keuntungan = $laporanPenjualan->keuntungan_persatuan * $laporanStokBarang->stok_keluar; 
        $laporanPenjualan->pendapatan_kotor = $laporanPenjualan->harga_jual * $laporanStokBarang->stok_keluar; 
        $laporanPenjualan->kerugian = abs($laporanPenjualan->harga_jual * $laporanStokBarang->stok_minus);
        $laporanPenjualan->pendapatan_sebenarnya = $laporanPenjualan->pendapatan_kotor - $laporanPenjualan->kerugian;
        $laporanPenjualan->save();
    }

    /**
     * Handle the LaporanStokBarang "deleted" event.
     */
    public function deleted(LaporanStokBarang $laporanStokBarang): void
    {
        //
    }

    /**
     * Handle the LaporanStokBarang "restored" event.
     */
    public function restored(LaporanStokBarang $laporanStokBarang): void
    {
        //
    }

    /**
     * Handle the LaporanStokBarang "force deleted" event.
     */
    public function forceDeleted(LaporanStokBarang $laporanStokBarang): void
    {
        //
    }
}
