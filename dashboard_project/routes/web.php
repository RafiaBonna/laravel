<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Eita add kora holo

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('master');
});


// index function-ke shobcheye beshi use kora path-e rakha holo
//to show all the users
Route::get('/home', [UserController::class, 'index']); 
Route::get('/index', [UserController::class, 'index']); 
//to show  add new user form
Route::get('create', [UserController::class, 'create'])->name('create');
//to store new user data to database
Route::post('store', [UserController::class, 'store'])->name('store');

// Route parameter 'catagory_id' er bodole 'user_id' dewa holo
//to show user edit form
Route::get('edit/{user_id}', [UserController::class, 'update'])->name('edit'); 
// after submiting editing form to update data
Route::post('edit-store', [UserController::class, 'editStore'])->name('editStore');
// to delete user data
Route::delete('delete', [UserController::class, 'destroy'])->name('delete');