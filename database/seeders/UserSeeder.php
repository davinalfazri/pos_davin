<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan User tanpa khawatir bentrok email
        User::firstOrCreate(
            ['email' => 'davin@gmail.com'], // Cek berdasarkan email
            [
                'name'     => 'Davin Alfazri',
                'password' => Hash::make('password'),
                'role_id'  => 1, // Sesuaikan ID Role Admin
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name'     => 'Kasir',
                'password' => Hash::make('password'),
                'role_id'  => 2, // Sesuaikan ID Role Kasir
            ]
        );
    }
}