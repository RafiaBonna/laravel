<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Eita add kora holo

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/master', function () {
    return view('master');
});

// index function-ke shobcheye beshi use kora path-e rakha holo
Route::get('/home', [UserController::class, 'index']); 
Route::get('/', [UserController::class, 'index']); 

Route::get('create', [UserController::class, 'create'])->name('create');
Route::post('store', [UserController::class, 'store'])->name('store');

// Route parameter 'catagory_id' er bodole 'user_id' dewa holo
Route::get('edit/{user_id}', [UserController::class, 'update'])->name('edit'); 

Route::post('edit-store', [UserController::class, 'editStore'])->name('editStore');

Route::delete('delete', [UserController::class, 'destroy'])->name('delete');