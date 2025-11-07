<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use App\Http\Controllers\Depo\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('depo')->group(function () {
    Route::middleware(['auth', 'role:depo'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // Distributor Management (CRUD)
        Route::resource('/users', UserController::class)->names('depo.users');

        
    });
});
