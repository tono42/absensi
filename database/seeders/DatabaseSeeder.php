<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Admin user
    User::create([
        'name' => 'Admin PDAM',
        'nip' => 'ADM001',
        'email' => 'admin@pdam.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    // Karyawan user
    User::create([
        'name' => 'Budi Santoso',
        'nip' => 'KRY001',
        'email' => 'budi@pdam.com',
        'password' => Hash::make('password'),
        'role' => 'karyawan',
    ]);

    User::create([
        'name' => 'Siti Aminah',
        'nip' => 'KRY002',
        'email' => 'siti@pdam.com',
        'password' => Hash::make('password'),
        'role' => 'karyawan',
    ]);
}
}
