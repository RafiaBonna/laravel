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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'Depot',
            'email' => 'depo@gmail.com',
            'role' => 'depo',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'Distributor',
            'email' => 'dist@gmail.com',
            'role' => 'distributor',
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
        // ⭐⭐ নতুন Super Admin ইউজার ⭐⭐
        User::create([
            'name' => 'SuperAdmin', 
            'email' => 'sup@gmail.com', // নতুন ইমেইল ব্যবহার করুন
            'role' => 'superadmin',           // ✅ নতুন রোল
            'status' => 'active',
            'password' => Hash::make('1234'),
        ]);
      
    }
}