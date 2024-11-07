<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            SatuanTableSeeder::class,
            KategoriTableSeeder::class,
            BarangTableSeeder::class,
            BarangKeluarTableSeeder::class,
            BarangMasukTableSeeder::class,
        ]);
    }
}
