<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\HomeController;
 use App\Http\Controllers\CategoryController;


Route::get('/welcome', function () {
    return view('welcome');
});

 Route::get('/home', [HomeController::class, 'index']);
 Route::get('/', [CategoryController::class, 'index']);

