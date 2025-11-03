<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use App\Http\Controllers\Depo\UserController;
use App\Http\Controllers\Depo\DepoShipmentController; // ✅ DepoShipmentController আমদানি
use Illuminate\Support\Facades\Route;

Route::prefix('depo')->group(function () {
    Route::middleware(['auth', 'role:depo'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // Distributor Management (CRUD)
        Route::resource('/users', UserController::class)->names('depo.users');

        // ✅ NEW: Raw Material Shipments Management for Depo (Receiving)
        Route::get('/shipments', [DepoShipmentController::class, 'index'])->name('depo.shipments.index');
        Route::post('/shipments/{shipment}/receive', [DepoShipmentController::class, 'receive'])->name('depo.shipments.receive');
    });
});
