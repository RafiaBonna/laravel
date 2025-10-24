<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class, // CountrySeeder আগে চলবে
            UserSeeder::class,    // UserSeeder পরে চলবে (কারণ এটি Country ID ব্যবহার করে)
        ]);
    }
}