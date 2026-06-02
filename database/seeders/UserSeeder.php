<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Arung',
            'email'    => 'admin@arungfutsal.com',
            'phone'    => '08123456789',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // User
        User::create([
            'name'     => 'Yahya Zahid',
            'email'    => 'yahya@gmail.com',
            'phone'    => '08198765432',
            'username' => 'redscale',
            'password' => Hash::make('123'),
            'role'     => 'user',
        ]);
    }
}