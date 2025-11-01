<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use Illuminate\Support\Facades\Route;

// সকল vendor routes-এর আগে '/vendor' prefix যোগ করা হলো
Route::prefix('depo')->group(function () {

    // এই group এর ভেতরের route-গুলিতে অ্যাক্সেস পেতে হলে
    // ইউজারকে অবশ্যই লগইন (auth) থাকতে হবে এবং তার role অবশ্যই 'vendor' হতে হবে।
    Route::middleware(['auth', 'role:depo'])->group(function () {
        
        // Vendor Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // ভবিষ্যতে Vendor-এর অন্যান্য রুট এইখানে যুক্ত হবে...
        // Route::resource('/products', ProductController::class);
    });
});