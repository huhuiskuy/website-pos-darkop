<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Jangan lupa import Hash buat enkripsi password

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Bikin akun default buat Back Office & POS
        User::create([
            'name' => 'Admin POS',
            'username' => 'huhuiskuuy',
            'email' => 'admin@pos.com', // Email wajib diisi karena bawaan tabel users Laravel butuh email
            'password' => Hash::make('admin123'), // Password wajib di-hash biar bisa dibaca sama Auth Laravel
        ]);
    }
}