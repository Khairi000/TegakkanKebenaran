<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan Seeder.
     */
    public function run(): void
    {
        // 🧩 Admin default
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // cari berdasarkan email
            [
                'name' => 'minn',
                'password' => Hash::make('000'),
                'role' => 'admin',
            ]
        );

        // 🧩 User Satu
        User::updateOrCreate(
            ['email' => 'khairii@gmail.com'],
            [
                'name' => 'User Satu',
                'password' => Hash::make('000'),
                'role' => 'user',
            ]
        );

        // 🧩 User Dua
        User::updateOrCreate(
            ['email' => 'key@gmail.com'],
            [
                'name' => 'User Dua',
                'password' => Hash::make('000'),
                'role' => 'user',
            ]
        );
    }
}
