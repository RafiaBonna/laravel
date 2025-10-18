<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth; // Auth ইম্পোর্ট করা হলো

// Auth Routes: এই একটি লাইন সব login, logout, register, password reset রুট তৈরি করে দেয়।
Auth::routes(); 

// welcome.blade.php
Route::get('/welcome', function () {
    return view('welcome');
});

// Default root page
Route::get('/', function () {
    return view('master');
});


// /home রুটে গেলে ইউজারকে তার রোল অনুযায়ী ড্যাশবোর্ডে পাঠিয়ে দেবে (যদি লগইন করা থাকে)
Route::get('/home', function () {
    if (Auth::check()) {
        // User.php এ নতুন ফাংশন ব্যবহার করে রোল অনুযায়ী ড্যাশবোর্ড ঠিক করা
        return redirect(Auth::user()->getDashboardRoute()); 
    }
    // যদি লগইন না করা থাকে, লগইন পেজে রিডাইরেক্ট করবে
    return redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| Admin Role Protected Routes
|--------------------------------------------------------------------------
| ইউজার CRUD রাউটগুলো 'admin' প্রিফিক্স ও 'admin' রোল মিডলওয়্যারের মাধ্যমে সুরক্ষিত করা হলো।
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin_index');
    })->name('admin.dashboard');

    // ইউজার ম্যানেজমেন্ট রুট (UserController)
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');             
        Route::get('/create', [UserController::class, 'create'])->name('create');       
        Route::post('/store', [UserController::class, 'store'])->name('store');         
        Route::get('/edit/{user_id}', [UserController::class, 'update'])->name('edit'); 
        Route::post('/edit-store', [UserController::class, 'editStore'])->name('editStore'); 
        Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');   
    });
});


// Distributor Dashboard (উদাহরণ)
Route::middleware(['auth', 'role:distributor'])->prefix('distributor')->group(function () {
    Route::get('/dashboard', function () {
        return view('master'); // ডিস্ট্রিবিউটর ভিউ
    })->name('distributor.dashboard');
});

// Depo Dashboard (উদাহরণ)
Route::middleware(['auth', 'role:depo'])->prefix('depo')->group(function () {
    Route::get('/dashboard', function () {
        return view('master'); // ডিপো ভিউ
    })->name('depo.dashboard');
});
