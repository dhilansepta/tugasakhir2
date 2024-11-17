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
            'kategori' => 'Minuman Gelas'
        ]);

        Kategori::create([
            'kategori' => 'Minuman Botol'
        ]);

        Kategori::create([
            'kategori' => 'Minuman Kaleng'
        ]);

        Kategori::create([
            'kategori' => 'Telur'
        ]);

        Kategori::create([
            'kategori' => 'Air Putih'
        ]);

        Kategori::create([
            'kategori' => 'Garam'
        ]);

        Kategori::create([
            'kategori' => 'Indomie'
        ]);

        Kategori::create([
            'kategori' => 'Mie'
        ]);

        Kategori::create([
            'kategori' => 'Minyak'
        ]);

        Kategori::create([
            'kategori' => 'Teh'
        ]);

        Kategori::create([
            'kategori' => 'Kerupuk'
        ]);

        Kategori::create([
            'kategori' => 'Susu'
        ]);

        Kategori::create([
            'kategori' => 'Kopi'
        ]);

        Kategori::create([
            'kategori' => 'Tepung'
        ]);

        Kategori::create([
            'kategori' => 'Gula'
        ]);

        Kategori::create([
            'kategori' => 'Isotonik'
        ]);

        Kategori::create([
            'kategori' => 'Bumbu'
        ]);
        
        Kategori::create([
            'kategori' => 'Soda'
        ]);

        Kategori::create([
            'kategori' => 'Sabun'
        ]);

    }
}
