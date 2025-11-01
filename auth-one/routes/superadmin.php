<?php

use App\Http\Controllers\Superadmin\SuperadminDashboardController; // ✅ নতুন কন্ট্রোলার
use Illuminate\Support\Facades\Route;

// সকল superadmin routes-এর আগে '/superadmin' prefix যোগ করা হলো
Route::prefix('superadmin')->group(function () {
    
    // role:superadmin মিডলওয়্যার ব্যবহার করা হলো
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Superadmin Dashboard Route: URL হবে /superadmin/dashboard
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ভবিষ্যতে Superadmin-এর অন্যান্য রুট এখানে যুক্ত হবে...
    });
});