<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController; // নতুন: Raw Material Receive-এর জন্য
use App\Http\Controllers\RawMaterialController; // নতুন: Raw Material Master-এর জন্য


Route::get('/', function () {
    return view('master');
});

// ===================================
// 1. User Management Routes
// ===================================
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/add-user', [UserController::class, 'create'])->name('userCreate');
Route::post('userStore', [UserController::class, 'store'])->name('userStore');
Route::get('userEdit/{user_id}', [UserController::class, 'update'])->name('userEdit');
Route::post('editStoreU', [UserController::class, 'editStoreU'])->name('editStoreU');
Route::delete('delete', [UserController::class, 'destroy'])->name('delete');


// ===================================
// 2. Supplier Management Routes
// ===================================
Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/add-supplier', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplierStore', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplierEdit/{supplier_id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/supplierUpdate', [SupplierController::class, 'updateStore'])->name('supplier.update');
Route::delete('/supplierDelete', [SupplierController::class, 'destroy'])->name('supplier.delete');


// ===================================
// 3. Raw Material & Stock In Routes (New Module)
// ===================================


Route::get('/raw-materials', [RawMaterialController::class, 'index'])->name('raw_material.index');
Route::get('/raw-materials/create', [RawMaterialController::class, 'create'])->name('raw_material.create');
Route::post('/raw-materials', [RawMaterialController::class, 'store'])->name('raw_material.store');
Route::get('/raw-materials/{id}/edit', [RawMaterialController::class, 'edit'])->name('raw_material.edit');
Route::put('/raw-materials/{id}', [RawMaterialController::class, 'update'])->name('raw_material.update');
Route::delete('/raw-materials/{id}', [RawMaterialController::class, 'destroy'])->name('raw_material.destroy');