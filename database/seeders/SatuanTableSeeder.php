<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create([
            'satuan' => 'Kilo'
        ]);

        Satuan::create([
            'satuan' => 'Dus'
        ]);
    }
}
