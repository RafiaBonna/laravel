<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users Management
    Route::resource('user', UserController::class);

    // Supplier
    Route::resource('supplier', SupplierController::class);

    // Raw Material
    Route::resource('raw_material', RawMaterialController::class);

    // Depot Management
    Route::resource('depot', DepotController::class);

    // Stock In
    Route::resource('stockin', StockInController::class);

    // Stock Out
    Route::resource('stockout', StockOutController::class);
});

require __DIR__.'/auth.php';
