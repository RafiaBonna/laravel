<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Password hash করার জন্য

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Country-গুলোর ID খুঁজে বের করা
        $countryBD = DB::table('countries')->where('name', 'Bangladesh')->first()->id;
        $countryIN = DB::table('countries')->where('name', 'India')->first()->id;
        $countryUS = DB::table('countries')->where('name', 'USA')->first()->id;
        
        // 2. User ডেটা যোগ করা
        DB::table('users')->insert([
            [
                'name' => 'Akash Rahman',
                'email' => 'akash@example.com',
                'password' => Hash::make('password'),
                'country_id' => $countryBD, // Bangladesh এর ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'password' => Hash::make('password'),
                'country_id' => $countryIN, // India এর ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'country_id' => $countryUS, // USA এর ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}