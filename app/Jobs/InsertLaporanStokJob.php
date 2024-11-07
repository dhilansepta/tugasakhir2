<?php

namespace App\Jobs;

use App\Models\Barang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class InsertLaporanStokJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Ambil semua barang dari model Barang
        $barangs = Barang::all();

        if ($barangs->isEmpty()) {
            Log::info('Tidak ada barang untuk diinsert.'); // Gunakan Log di sini
            return; // Keluar dari fungsi jika tidak ada barang
        }

        foreach ($barangs as $barang) {
            // Hitung stok, bisa menambahkan logika sesuai kebutuhan
            $stokAwal = $barang->stok; // Misalnya, stok awal bisa dari hasil sebelumnya
            $stokMasuk = 0;  // Misalnya, stok masuk didapat dari sumber lain
            $stokKeluar = 0; // Misalnya, stok keluar juga didapat dari sumber lain
            
            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar; // Hitung stok akhir
            
            $stokGudang = 0;
            $stokMinus = $stokGudang - $stokAkhir;

            // Data yang akan diinsert
            $data = [
                'tanggal' => now(), // Atau ambil tanggal sesuai kebutuhan
                'barang_id' => $barang->id, // Menggunakan ID barang dari model
                'stok_awal' => $stokAwal,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'stok_akhir' => $stokAkhir,
                'stok_gudang' => $stokGudang, 
                'stok_minus' => $stokMinus,
            ];

            // Insert data ke dalam tabel laporanstokbarang
            DB::table('laporanstokbarang')->insert($data);
        }

        Log::info('Data laporan stok berhasil diinsert untuk semua barang!'); // Gunakan Log di sini
    }
}
