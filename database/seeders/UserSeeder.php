<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name'     => 'Admin CS2',
            'email'    => 'admin@cs2.id',
            'password' => Hash::make('Admin1234!'),
            'role'     => 'admin',
        ]);

        // Akun User Demo
        User::create([
            'name'     => 'Demo User',
            'email'    => 'demo@cs2.id',
            'password' => Hash::make('Demo1234!'),
            'role'     => 'user',
        ]);
    }
}