<?php

use Illuminate\Support\Facades\Route;
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
