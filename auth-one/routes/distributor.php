<?php

use App\Http\Controllers\Distributor\DistributorDashboardController;
use App\Http\Controllers\Distributor\CustomerController; // ✅ আমদানি
use Illuminate\Support\Facades\Route;

Route::prefix('distributor')->group(function () {
    Route::middleware(['auth', 'role:distributor'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [DistributorDashboardController::class, 'index'])->name('distributor.dashboard');

        // ✅ CRITICAL FIX: Customer Management (CRUD)
        Route::resource('/customers', CustomerController::class)->names('distributor.customers');
    });
});