<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * একটি ক্যাটাগরির মাধ্যমে তার প্রথম Order-এর ডেটা লোড করে ভিউতে প্রদর্শন করে।
     */
    public function showFirstOrder(string $id)
    {
        // ক্যাটাগরিটি খুঁজে বের করা হচ্ছে এবং 'firstOrder' রিলেশনশিপটি Eager Load করা হচ্ছে।
        // Eager loading ডেটাবেজ কোয়েরির সংখ্যা কমিয়ে পারফরম্যান্স উন্নত করে।
        $category = Category::with('firstOrder')->findOrFail($id);

        // ভিউতে ডেটা পাস করা। 'firstOrder' হল hasOneThrough রিলেশনশিপের মেথডের নাম।
        return view('category-order', [
            'category' => $category,
            'order' => $category->firstOrder, 
        ]);
    }
}