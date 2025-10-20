<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default suppliers data
        $suppliers = [
            [
                'name' => 'ABC Traders',
                'email' => 'abc@gmail.com',
                'phone' => '01700000000',
                'address' => 'Dhaka, Bangladesh',
            ],
            [
                'name' => 'Global Suppliers Ltd.',
                'email' => 'global@example.com',
                'phone' => '01811111111',
                'address' => 'Chittagong, Bangladesh',
            ],
            [
                'name' => 'Sunrise Enterprise',
                'email' => 'sunrise@gmail.com',
                'phone' => '01922222222',
                'address' => 'Khulna, Bangladesh',
            ],
            [
                'name' => 'Mega Importers',
                'email' => 'mega@gmail.com',
                'phone' => '01633333333',
                'address' => 'Rajshahi, Bangladesh',
            ],
        ];

        // Insert all suppliers
        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
