<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRedirectController; // ✅ এটি যোগ করতে হবে
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
| এই রুটটি লগইন করার পর ইউজারকে তার role অনুযায়ী সঠিক ড্যাশবোর্ডে রিডাইরেক্ট করবে।
*/
// (১) /dashboard route টি এখন RoleRedirectController কে কল করবে।
Route::get('/dashboard', [RoleRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); // ✅ এই name টি login এর পর ডিফল্ট redirect হিসেবে ব্যবহৃত হবে


/*
|--------------------------------------------------------------------------
| General User Dashboard (Customer/Rider)
|--------------------------------------------------------------------------
| RoleRedirectController থেকে এই রুটে redirect হবে যখন role 'admin' বা 'vendor' না হবে।
*/
// (২) ডিফল্ট ইউজারদের জন্য একটি নতুন route, যা অরিজিনাল dashboard view দেখাবে।
Route::get('/general/dashboard', function () {
    return view('dashboard'); // resources/views/dashboard.blade.php ফাইলটি লোড হবে
})->middleware(['auth', 'verified'])->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Profile)
|--------------------------------------------------------------------------
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
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php'; // ✅ Admin routes
require __DIR__ . '/vendor.php'; // ✅ Vendor routes
// require __DIR__ . '/customer.php'; // যদি customer.php ফাইল না থাকে, তবে এই লাইনটি বাদ দেওয়া যেতে পারে