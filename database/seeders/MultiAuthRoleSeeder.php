<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MultiAuthRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Set admin yang sudah ada jadi owner
        $owner = User::first();
        if ($owner) {
            $owner->role = 'owner';
            $owner->save();
        }

        // 2. Buat akun barista default jika belum ada
        $barista = User::where('role', 'barista')->first();
        if (!$barista) {
            User::create([
                'name' => 'Barista Kedai',
                'username' => 'barista',
                'email' => 'barista@darikopi.com',
                'password' => Hash::make('darikopi123'),
                'role' => 'barista'
            ]);
        }
    }
}
