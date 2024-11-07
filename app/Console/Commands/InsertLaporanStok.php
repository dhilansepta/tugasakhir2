<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\LaporanStokBarang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertLaporanStok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert-laporan-stok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $laporanstok = LaporanStokBarang::where('barang_id', $barang->id)
                ->latest('id')
                ->first();

            // Hitung stok akhir, dan bisa menambahkan logika sesuai kebutuhan
            // $stokAwal = $laporanstok && $laporanstok->stok_gudang == '0'  ? $barang->stok : $laporanstok->stok_gudang;
            $stokAwal = $laporanstok && isset($laporanstok->stok_gudang) && $laporanstok->stok_gudang == '0'
                ? $barang->stok
                : ($laporanstok->stok_gudang ?? $barang->stok);

            $stokMasuk = 0;
            $stokKeluar = 0;

            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar; // Hitung stok akhir

            $stokGudang = 0;
            $stokMinus = 0;

            // Data yang akan diinsert
            $data_laporanStok = [
                'created_at' => now(), // Atau ambil tanggal sesuai kebutuhan
                'updated_at' => now(),
                'barang_id' => $barang->id, // Menggunakan ID barang dari model
                'stok_awal' => $stokAwal,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'stok_akhir' => $stokAkhir,
                'stok_gudang' => $stokGudang, // Jika ada logika lain untuk stok gudang
                'stok_minus' => $stokMinus, // Hitung sesuai logika yang diinginkan
            ];

            // Insert data ke dalam tabel laporanstokbarang
            $laporanStokId = DB::table('laporanstokbarang')->insertGetId($data_laporanStok);

            DB::table('barang')
                ->where('id', $laporanstok->barang_id)
                ->update(['stok' => $stokAwal]);

            $stokTerjual = $stokKeluar;
            $hargaJual = $barang->harga_jual;

            //$stokMinus = $stokMinus;

            $pendapatanKotor = $stokTerjual * $hargaJual;
            $kerugian = abs($stokMinus * $hargaJual);

            $pendapatanSebenarnya = $pendapatanKotor - $kerugian;

            $data_laporanPenjualan = [
                'created_at' => now(),
                'updated_at' => now(),
                'laporan_id' => $laporanStokId,
                'pendapatan_kotor' => $pendapatanKotor,
                'kerugian' => $kerugian,
                'pendapatan_sebenarnya' => $pendapatanSebenarnya,
            ];
            DB::table('laporanpenjualan')->insert($data_laporanPenjualan);
        }

        $this->info('Data laporan stok berhasil diinsert!');
        $this->info('Data laporan penjualan berhasil diinsert!');
    }
}
