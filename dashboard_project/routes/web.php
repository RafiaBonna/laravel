<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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
        // এই রুটিংটি Auth::user()->getDashboardRoute() ফাংশনের উপর নির্ভর করে
        return redirect(Auth::user()->getDashboardRoute()); 
    }
    // যদি লগইন না করা থাকে, লগইন পেজে রিডাইরেক্ট করবে
    return redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| Admin Role Protected Routes
|--------------------------------------------------------------------------
| ইউজার CRUD রাউটগুলো 'admin' প্রিফিক্স ও 'admin' মিডলওয়্যারের মাধ্যমে সুরক্ষিত করা হলো।
*/
// ✅ ফিক্স: 'role:admin' এর বদলে 'admin' মিডলওয়্যার অ্যালিয়াস ব্যবহার করা হলো
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin_index');
    })->name('admin.dashboard');

    // ইউজার ম্যানেজমেন্ট রুট (UserController)
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');             
        Route::get('/create', [UserController::class, 'create'])->name('create');       
        Route::post('/store', [UserController::class, 'store'])->name('store');         
        // ✅ ফিক্স: UserController-এ update এর পরিবর্তে edit মেথডকে কল করা হলো
        Route::get('/edit/{user_id}', [UserController::class, 'edit'])->name('edit'); 
        Route::post('/edit-store', [UserController::class, 'editStore'])->name('editStore'); 
        Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');   
    });
});


/*
|--------------------------------------------------------------------------
| Other Role Specific Dashboard Routes
|--------------------------------------------------------------------------
| এই রুটগুলি লগইন করা সাপেক্ষে প্রত্যেকের ড্যাশবোর্ড প্রদর্শন করে।
*/

// Distributor Dashboard
Route::middleware('auth')->prefix('distributor')->group(function () {
    Route::get('/dashboard', function () {
        // 'distributor_index' ভিউ ফাইল লোড করবে
        return view('distributor_index'); 
    })->name('distributor.dashboard');
});

// Depo Dashboard
Route::middleware('auth')->prefix('depo')->group(function () {
    Route::get('/dashboard', function () {
        // 'depo_index' ভিউ ফাইল লোড করবে
        return view('depo_index'); 
    })->name('depo.dashboard');
});