<?php

// routes/superadmin.php

use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SupplierController; // ✅ নতুন Controller আমদানি

use Illuminate\Support\Facades\Route;

// All Superadmin Routes (Prefix: superadmin)
Route::prefix('superadmin')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ADMINISTRATION
        Route::resource('/users', UserController::class)->names('superadmin.users');

        // --- SETTINGS ---
        // ✅ Supplier Management Resource Route
        // আমরা Settings মেনুর অধীনে রাখলেও রুট-এর নাম সহজ রাখছি: superadmin.suppliers.*
        Route::resource('/suppliers', SupplierController::class)->names('superadmin.suppliers'); 
     
    });
});