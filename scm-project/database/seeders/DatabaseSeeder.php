<?php

namespace Database\Seeders;

// প্রয়োজনীয় Seeder ক্লাসগুলো ইমপোর্ট করুন
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SupplierSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call() এর মধ্যে আপনার সব Seeder ক্লাসগুলো যোগ করুন
        $this->call([
            RoleSeeder::class,      // roles টেবিল populate করবে
            SupplierSeeder::class,
            UserSeeder::class,  // suppliers টেবিল populate করবে
            // আপনার অন্যান্য সেডার এখানে যোগ করুন...
        ]);
    }
}