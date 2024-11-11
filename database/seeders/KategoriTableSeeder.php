<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'kategori' => 'Minuman'
        ]);

        Kategori::create([
            'kategori' => 'Makanan'
        ]);

        Kategori::create([
            'kategori' => 'Bahan Pokok'
        ]);

        Kategori::create([
            'kategori' => 'Telur'
        ]);
    }
}
