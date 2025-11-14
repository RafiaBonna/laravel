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

    // Dashboard Route
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])
        ->name('superadmin.dashboard');

    // User Management (CRUD)
    Route::resource('/users', UserController::class)
        ->names('superadmin.users');

    // ------------------------------------------
    // RAW MATERIAL MANAGEMENT
    // ------------------------------------------
    Route::resource('/raw-materials', RawMaterialController::class)
        ->names('superadmin.raw-materials');

    Route::resource('/raw-material-purchases', RawMaterialPurchaseController::class)
        ->names('superadmin.raw-material-purchases');

    Route::resource('/raw-material-stock-out', RawMaterialStockOutController::class)
        ->names('superadmin.raw-material-stock-out');

    // FIX: Missing Route for Stock Report (superadmin.raw-material-stock.index)
    // Assume it uses a method in RawMaterialController or a dedicated controller
    // If you have a dedicated controller for stock, replace RawMaterialController::class
    Route::get('/raw-material-stock', [RawMaterialController::class, 'stockIndex'])
        ->name('superadmin.raw-material-stock.index');
        
    Route::resource('/wastage', WastageController::class) // Changed to resource based on sidebar link
        ->names('superadmin.wastage');
        
    // ------------------------------------------
    // PRODUCT & STOCK MANAGEMENT
    // ------------------------------------------
    
    // 1. Product Management (CRUD)
    Route::resource('/products', ProductController::class)
        ->names('superadmin.products');

    // 2. Product Receive/Purchase (CRUD)
    Route::resource('/product-receives', ProductReceiveController::class)
        ->names('superadmin.product-receives');


    // 3. SALES MANAGEMENT (BATCH FIX CONFIRMED HERE)
    Route::prefix('sales')->controller(SalesInvoiceController::class)->name('superadmin.sales.')->group(function () {
        Route::get('/', 'index')->name('index');       
        Route::get('/create', 'create')->name('create'); 
        Route::post('/', 'store')->name('store');       

        // API: Fix for batch dropdown (superadmin.sales.api.product-stock.batches)
        Route::get('/api/product-stock/batches/{productId}', 'getProductBatches')->name('api.product-stock.batches');
    });

    // 4. Return Management (Future)
    // 5. Wastage Management (Future)

    // ------------------------------------------
    // SETTINGS & MASTER DATA
    // ------------------------------------------

    // Supplier Management (CRUD)
    Route::resource('/suppliers', SupplierController::class)
        ->names('superadmin.suppliers');

    // Depo Management (List only)
    Route::get('/depo', [DepoListController::class, 'index'])
        ->name('superadmin.depo.index');

    // Distributor Management (List only)
    Route::get('/distributor', [DepoListController::class, 'index'])
        ->name('superadmin.distributor.index');
});