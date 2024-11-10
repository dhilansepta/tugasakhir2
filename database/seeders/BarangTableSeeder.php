<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'nama_barang' => 'Ale-Ale',
            'kategori_id' => '1',
            'satuan_id' => '2',
            'harga_beli' => '17000',
            'harga_jual' => '19000',
            'keuntungan' => '2000',
            'stok' => '30',
        ]);

        Barang::create([
            'nama_barang' => 'Aqua 1,5L',
            'kategori_id' => '1',
            'satuan_id' => '2',
            'harga_beli' => '40000',
            'harga_jual' => '48000',
            'keuntungan' => '8000',
            'stok' => '40',
        ]);

        Barang::create([
            'nama_barang' => 'Telur',
            'kategori_id' => '3',
            'satuan_id' => '1',
            'harga_beli' => '19000',
            'harga_jual' => '28000',
            'keuntungan' => '9000',
            'stok' => '30',
        ]);
    }
}
