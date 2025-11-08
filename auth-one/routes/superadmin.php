<?php

// routes/superadmin.php

use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SupplierController; // ✅ SupplierController আমদানি করা হয়েছে

use Illuminate\Support\Facades\Route;

// All Superadmin Routes (Prefix: superadmin)
Route::prefix('superadmin')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ADMINISTRATION
        Route::resource('/users', UserController::class)->names('superadmin.users');

        // --- INVENTORY / SETTINGS ---
        // ✅ Supplier Management Resource Route
        // রুট-এর নাম: superadmin.suppliers.*
        Route::resource('/suppliers', SupplierController::class)->names('superadmin.suppliers'); 
     
    });
});