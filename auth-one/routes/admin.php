<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// সকল admin routes-এর আগে '/admin' prefix যোগ করা হলো
Route::prefix('admin')->group(function () {

    // এই group এর ভেতরের route-গুলিতে অ্যাক্সেস পেতে হলে
    // ইউজারকে অবশ্যই লগইন (auth) থাকতে হবে এবং তার role অবশ্যই 'admin' হতে হবে।
    Route::middleware(['auth', 'role:admin'])->group(function () {
        
        // Admin Dashboard Route
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // ভবিষ্যতে Admin-এর অন্যান্য রুট এইখানে যুক্ত হবে...
        // Route::resource('/categories', CategoryController::class);
    });
});