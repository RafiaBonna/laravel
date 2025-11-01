<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use App\Http\Controllers\Depo\UserController; // ✅ Depo-এর Distributor Management-এর জন্য UserController আমদানি
use Illuminate\Support\Facades\Route;

Route::prefix('depo')->group(function () {
    Route::middleware(['auth', 'role:depo'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // ✅ CRITICAL FIX: Distributor Management (CRUD)
        // Note: Depo-এর অধীনে Distributor-রা UserController দ্বারা পরিচালিত হয়
        Route::resource('/users', UserController::class)->names('depo.users');
    });
});