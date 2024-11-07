<?php

namespace App\Console\Commands;

use App\Models\LaporanStokBarang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertLaporanPenjualan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert-laporan-penjualan';

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
        $laporanstoks = LaporanStokBarang::all();

        foreach ($laporanstoks as $laporanstok) {

            $stokTerjual = $laporanstok->stok_keluar;
            $hargaJual = $laporanstok->barang->harga_jual;

            $stokMinus = $laporanstok->stok_minus;

            $pendapatanKotor = $stokTerjual * $hargaJual;
            $kerugian = abs($stokMinus * $hargaJual);

            $pendapatanSebenarnya = $pendapatanKotor - $kerugian;

            $data_laporan = [
                'created_at' => now(),
                'updated_at' => now(),
                'laporan_id' => $laporanstok->id,
                'pendapatan_kotor' => $pendapatanKotor,
                'kerugian' => $kerugian,
                'pendapatan_sebenarnya' => $pendapatanSebenarnya,
            ];

            DB::table('laporanpenjualan')->insert($data_laporan);
        }
    }
}
