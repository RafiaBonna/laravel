<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@gmail.com',
            'role' => 'vendor',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'Rider User',
            'email' => 'rider@gmail.com',
            'role' => 'rider',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
    }
}