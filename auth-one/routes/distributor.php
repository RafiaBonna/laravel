<?php

use App\Http\Controllers\Distributor\DistributorDashboardController;
use Illuminate\Support\Facades\Route;

// সকল distributor routes-এর আগে '/distributor' prefix যোগ করা হলো
Route::prefix('distributor')->group(function () {

    // এই group এর ভেতরের route-গুলিতে অ্যাক্সেস পেতে হলে
    // ইউজারকে অবশ্যই লগইন (auth) থাকতে হবে এবং তার role অবশ্যই 'distributor' হতে হবে।
    Route::middleware(['auth', 'role:distributor'])->group(function () {
        
        // Distributor Dashboard Route
        Route::get('/dashboard', [DistributorDashboardController::class, 'index'])->name('distributor.dashboard');

        // ভবিষ্যতে Distributor-এর অন্যান্য রুট এইখানে যুক্ত হবে...
        // Route::resource('/orders', DistributorOrderController::class);
    });
});
