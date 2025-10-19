<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HasOneThroughController;
Route::get('/master', function () {
    return view('master');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('home');
});
Route::get('/add-user', function () {
    return view('pages.user');
});
Route::get('/manage-user', function () {
    return view('pages.manage-user');
});
Route::get('/a', [HasOneThroughController::class,'index']);