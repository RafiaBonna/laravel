<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DB Facade ব্যবহার করতে হবে

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // নিশ্চিত করুন যে Country মডেলের fillable property-তে 'name' আছে
        DB::table('countries')->insert([
            ['name' => 'Bangladesh'],
            ['name' => 'India'],
            ['name' => 'USA'],
            ['name' => 'Canada'],
        ]);
    }
}