<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SupplierController;
use App\Http\Controllers\Superadmin\DepoListController; // ✅ DepoListController যুক্ত করা হয়েছে

/*
|--------------------------------------------------------------------------
| Superadmin Routes
|--------------------------------------------------------------------------
| Prefix: superadmin
| Middleware: auth, role:superadmin
|--------------------------------------------------------------------------
*/
Route::prefix('superadmin')->middleware(['auth', 'role:superadmin'])->group(function () {

    // 🏠 Dashboard Route
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])
        ->name('superadmin.dashboard');

    // 👥 User Management (CRUD)
    // Route name prefix → superadmin.users.*
    Route::resource('/users', UserController::class)
        ->names('superadmin.users');

    // 🏭 Supplier Management (CRUD)
    // Route name prefix → superadmin.suppliers.*
    Route::resource('/suppliers', SupplierController::class)
        ->names('superadmin.suppliers');

    // 🏬 Depo Management (List only)
    // ✅ এই রুটটাই এরর ঠিক করবে
    Route::get('/depo', [DepoListController::class, 'index'])
        ->name('superadmin.depo.index');
});
