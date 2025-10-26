<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class CategoryProductOrderSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::create(['name' => 'Mobile Phones']);

        // এই Product-এর Order টি hasOneThrough দিয়ে পাওয়া যাবে
        $productA = Product::create([
            'category_id' => $category->id,
            'name' => 'Model X'
        ]);

        $productB = Product::create([
            'category_id' => $category->id,
            'name' => 'Model Y'
        ]);

        // প্রথম Product-এর অর্ডার
        Order::create([
            'product_id' => $productA->id,
            'name' => 'First Order for Model X' 
        ]);

        // দ্বিতীয় Product-এর অর্ডার
        Order::create([
            'product_id' => $productB->id,
            'name' => 'Second Order for Model Y'
        ]);
    }
}