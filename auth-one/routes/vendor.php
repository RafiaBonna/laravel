<?php

use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

// সকল vendor routes-এর আগে '/vendor' prefix যোগ করা হলো
Route::prefix('vendor')->group(function () {

    // এই group এর ভেতরের route-গুলিতে অ্যাক্সেস পেতে হলে
    // ইউজারকে অবশ্যই লগইন (auth) থাকতে হবে এবং তার role অবশ্যই 'vendor' হতে হবে।
    Route::middleware(['auth', 'role:vendor'])->group(function () {
        
        // Vendor Dashboard Route
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');

        // ভবিষ্যতে Vendor-এর অন্যান্য রুট এইখানে যুক্ত হবে...
        // Route::resource('/products', ProductController::class);
    });
});