<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SupplierController;
use App\Http\Controllers\Superadmin\DepoListController;
use App\Http\Controllers\Superadmin\RawMaterialController; // ✅ NEW
use App\Http\Controllers\Superadmin\RawMaterialPurchaseController; // ✅ NEW (Next Step)
use App\Http\Controllers\Superadmin\RawMaterialStockOutController; // ✅ NEW (Next Step)
use App\Http\Controllers\Superadmin\WastageController; // ✅ NEW (Next Step)


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

    // ------------------------------------------
    // 📦 RAW MATERIAL MANAGEMENT (NEW SECTION)
    // ------------------------------------------
    
    // 1. Raw Material List (CRUD)
    Route::resource('/raw-materials', RawMaterialController::class)
        ->names('superadmin.raw-materials');

    // 2. Stock In / Purchase (পরবর্তী ধাপের জন্য)
    // Controller-টি এখনো তৈরি না হলেও Route name সেট করা হলো
    Route::resource('/raw-material-purchases', RawMaterialPurchaseController::class)
        ->names('superadmin.raw-material-purchases');

    // 3. Stock Out / Production Issue (পরবর্তী ধাপের জন্য)
    // Controller-টি এখনো তৈরি না হলেও Route name সেট করা হলো
    Route::resource('/raw-material-stock-out', RawMaterialStockOutController::class)
        ->names('superadmin.raw-material-stock-out');

    // 4. Stock Report & Wastage (পরবর্তী ধাপের জন্য)
    // এখানে আপাতত RawMaterialStockOutController-কে ডামি হিসেবে ব্যবহার করা হয়েছে।
    Route::get('/raw-material-stock-report', [RawMaterialStockOutController::class, 'index'])->name('superadmin.raw-material-stock.index'); 
    Route::resource('/wastage', WastageController::class)->names('superadmin.wastage');


    // ------------------------------------------
    // ⚙️ SETTINGS & MASTER DATA (Existing Routes)
    // ------------------------------------------

    // 🏭 Supplier Management (CRUD)
    // Route name prefix → superadmin.suppliers.*
    Route::resource('/suppliers', SupplierController::class)
        ->names('superadmin.suppliers');

    // 🏬 Depo Management (List only)
    // ✅ এই রুটটাই এরর ঠিক করবে
    Route::get('/depo', [DepoListController::class, 'index'])
        ->name('superadmin.depo.index');
});