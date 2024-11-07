<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Alvira Sudirman',
            'username' => 'alvirasdrmn',
            'password' => Hash::make('alvira123'),
            'role' => 'Owner',
            'status' => 'Aktif',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Dhilan Septa Yudha',
            'username' => 'dhilansepta',
            'password' => Hash::make('dhilan123'),
            'role' => 'Karyawan',
            'status' => 'Aktif',
            'remember_token' => Str::random(10),
        ]);
    }
}