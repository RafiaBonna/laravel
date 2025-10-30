<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRedirectController; // ✅ এই Controller টি লগইন রিডাইরেক্ট হ্যান্ডেল করবে
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Multi-Role Redirect
|--------------------------------------------------------------------------
| এই রুটটি /dashboard URL-এ হিট করলে ইউজারকে তার role অনুযায়ী সঠিক ড্যাশবোর্ডে পাঠাবে।
| যেমন: /admin/dashboard বা /vendor/dashboard
*/

Route::get('/dashboard', [RoleRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Profile)
|--------------------------------------------------------------------------
| এই রুটগুলো সব লগইন করা ইউজারের জন্য।
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Role Specific Routes
|--------------------------------------------------------------------------
| Admin এবং Vendor এর জন্য আলাদা Route ফাইল লোড করা হলো।
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php'; // ✅ Admin routes
require __DIR__ . '/vendor.php'; // ✅ Vendor routes
// require __DIR__ . '/customer.php'; // ❌ এই লাইনটি বাদ দেওয়া হলো