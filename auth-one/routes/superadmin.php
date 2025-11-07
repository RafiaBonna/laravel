<?php

use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;

use Illuminate\Support\Facades\Route;

// All Superadmin Routes (Prefix: superadmin)
Route::prefix('superadmin')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ADMINISTRATION
        Route::resource('/users', UserController::class)->names('superadmin.users');
        
     
    });
});
