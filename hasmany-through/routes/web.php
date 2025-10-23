<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// সকল দেশ এবং তাদের পোস্টগুলি দেখুন
Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');

// একটি নির্দিষ্ট দেশ এবং তাদের পোস্টগুলি দেখুন
Route::get('/countries/{country}', [CountryController::class, 'show'])->name('countries.show');
// পোস্ট তৈরি করার ফর্ম এবং টেবিল দেখানোর জন্য
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// পোস্ট সাবমিট করার জন্য
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// ... আপনার অন্যান্য রাউট ...