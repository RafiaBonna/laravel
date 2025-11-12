<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SupplierController;
use App\Http\Controllers\Superadmin\DepoListController;
use App\Http\Controllers\Superadmin\RawMaterialController;
use App\Http\Controllers\Superadmin\RawMaterialPurchaseController;
use App\Http\Controllers\Superadmin\RawMaterialStockOutController;
use App\Http\Controllers\Superadmin\WastageController; 
// ⬅️ নতুন Controller Import
use App\Http\Controllers\Superadmin\ProductController;
use App\Http\Controllers\Superadmin\ProductReceiveController;
use App\Http\Controllers\Superadmin\SalesInvoiceController;


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
    // 📦 RAW MATERIAL MANAGEMENT (EXISTING SECTION)
    // ------------------------------------------
    
    // 1. Raw Material List (CRUD)
    Route::resource('/raw-materials', RawMaterialController::class)
        ->names('superadmin.raw-materials');

    // 2. Stock In / Purchase
    Route::resource('/raw-material-purchases', RawMaterialPurchaseController::class)
        ->names('superadmin.raw-material-purchases');

    // 3. Stock Out / Production Issue
    Route::resource('/raw-material-stock-out', RawMaterialStockOutController::class)
        ->names('superadmin.raw-material-stock-out');

    // ✅ API: Fetch Stock Batches for the Stock Out form
    Route::get('/api/raw-material-stock/batches/{rawMaterialId}', [RawMaterialStockOutController::class, 'getStockBatches'])
        ->name('superadmin.api.raw-material-stock.batches');

    // 4. Stock Report & Wastage
    Route::get('/raw-material-stock-report', [RawMaterialStockOutController::class, 'index'])->name('superadmin.raw-material-stock.index'); 
    Route::resource('/wastage', WastageController::class)->names('superadmin.wastage');

    // 🎯 FIX: Wastage ফর্মের জন্য ব্যাচ লোড করার নতুন API
    Route::get('/api/wastage/batches/{rawMaterialId}', [WastageController::class, 'getStockBatches'])
        ->name('superadmin.api.wastage.batches');


    // ------------------------------------------
    // 🏭 PRODUCT MANAGEMENT (NEW SECTION)
    // ------------------------------------------

    // 1. Product List (CRUD) - Jeta Product Entry hisebe kaj korbe
    Route::resource('/products', ProductController::class)
        ->names('superadmin.products'); // Route name prefix → superadmin.products.*

    // 2. Product Receive (Karkhana theke warehouse a asha) - Multi Product Add
    Route::prefix('product-receives')->controller(ProductReceiveController::class)->name('superadmin.product-receives.')->group(function () {
        Route::get('/', 'index')->name('index'); // Product Receive List
        Route::get('/create', 'create')->name('create'); // Product Receive Form
        Route::post('/', 'store')->name('store'); // Save Receive Data
        // View, Edit, Delete পরে যোগ করা যাবে
    });
    
    // 3. 📦 Sales Management (Superadmin to Depo)
    Route::prefix('product-sales')->controller(SalesInvoiceController::class)->name('superadmin.product-sales.')->group(function () {
        Route::get('/', 'index')->name('index'); // Sales List (Jekhane Yellow/Red status show hobe)
        Route::get('/create', 'create')->name('create'); // Sales Form
        Route::post('/', 'store')->name('store'); // Save Sales Invoice (Status: Pending)

        // API: Sales ফর্মের জন্য প্রোডাক্টের ব্যাচ লোড করার জন্য
        Route::get('/api/product-stock/batches/{productId}', [SalesInvoiceController::class, 'getProductBatches'])->name('superadmin.api.product-stock.batches');
    });

    // 4. Return Management (Future)
    // 5. Wastage Management (Future)

    // ------------------------------------------
    // ⚙️ SETTINGS & MASTER DATA (Existing Routes)
    // ------------------------------------------

    // 🏭 Supplier Management (CRUD)
    // Route name prefix → superadmin.suppliers.*
    Route::resource('/suppliers', SupplierController::class)
        ->names('superadmin.suppliers');

    // 🏬 Depo Management (List only)
    Route::get('/depo', [DepoListController::class, 'index'])
        ->name('superadmin.depo.index'); 
    
    // 🚚 Distributor Management (List only)
    Route::get('/distributor', [DepoListController::class, 'index'])
        ->name('superadmin.distributor.index'); 
    
    // ------------------------------------------
});