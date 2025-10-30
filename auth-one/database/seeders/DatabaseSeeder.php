<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // এখন এটি শুধুমাত্র আপনার কাস্টম UserSeeder-টি কল করবে, যেখানে চারটি ইউজার আছে।
        $this->call(UserSeeder::class);
    }
}