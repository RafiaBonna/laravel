<?php

use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController; // ✅ Superadmin-এর User Management-এর জন্য UserController আমদানি
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ✅ CRITICAL FIX: User Management (CRUD) for Depo/Distributor
        Route::resource('/users', UserController::class)->names('superadmin.users');
    });
});