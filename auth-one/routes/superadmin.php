<?php

use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\DepoController; // ✅ DepoController আমদানি
use App\Http\Controllers\Superadmin\RawMaterialController;
use App\Http\Controllers\Superadmin\RawMaterialReceivingController;
use App\Http\Controllers\Superadmin\RawMaterialConsumptionController;
use App\Http\Controllers\Superadmin\RawMaterialShipmentController;
use Illuminate\Support\Facades\Route;

// All Superadmin Routes (Prefix: superadmin)
Route::prefix('superadmin')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        // ADMINISTRATION
        Route::resource('/users', UserController::class)->names('superadmin.users');
        
        // ✅ MISSING ROUTE DEFINITION: Depo Management
        Route::resource('/depos', DepoController::class)->names('superadmin.depos'); 

        // RAW MATERIAL MANAGEMENT
        Route::resource('/raw-materials', RawMaterialController::class)->names('superadmin.raw_materials');
        Route::resource('/raw-material-receivings', RawMaterialReceivingController::class)->names('superadmin.raw_material_receivings');
        Route::resource('/raw-material-consumptions', RawMaterialConsumptionController::class)->names('superadmin.raw_material_consumptions');
        Route::resource('/raw-material-shipments', RawMaterialShipmentController::class)->names('superadmin.raw_material_shipments');
    });
});
