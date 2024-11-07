<?php

namespace Database\Seeders;

use App\Models\LaporanStokBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanStokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LaporanStokBarang::create([
            'barang_id' => '1',
            'stok_awal' => '30',
            'stok_akhir' => '30',
            'stok_gudang' => '28',
        ]);

        LaporanStokBarang::create([
            'barang_id' => '2',
            'stok_awal' => '40',
            'stok_akhir' => '40',
            'stok_gudang' => '40',
        ]);
    }
}
