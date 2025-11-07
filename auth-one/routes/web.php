<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRedirectController; // ✅ RoleRedirectController আমদানি করা হয়েছে

/*
|--------------------------------------------------------------------------
| Default Route → Login
|--------------------------------------------------------------------------
| '/' রুটে গেলে সরাসরি লগইন পেজে রিডাইরেক্ট করবে।
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Role Based Dashboard Redirect
|--------------------------------------------------------------------------
| লগইন করার পর, এই রুটটি ইউজারকে তার রোল অনুযায়ী সঠিক ড্যাশবোর্ডে পাঠাবে।
*/
Route::get('/dashboard', [RoleRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); // প্রধান ড্যাশবোর্ড রুট

/*
|--------------------------------------------------------------------------
| General User Dashboard
|--------------------------------------------------------------------------
| যদি RoleRedirectController কোনো নির্দিষ্ট রোলের জন্য রুট না খুঁজে পায়,
| তবে এটি ডিফল্ট ইউজার ড্যাশবোর্ডে পাঠাতে পারে।
*/
Route::get('/general/dashboard', function () {
    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('user.dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Logout Route (Breeze Auth)
|--------------------------------------------------------------------------
| লগআউট রুটটি 'auth.php' ফাইল থেকে আসার কথা, তবে নিশ্চিত করার জন্য এখানে রাখা যেতে পারে
| অথবা যদি আপনি কাস্টম লগআউট চান, তবে এটি ব্যবহার করতে পারেন।
*/
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Include Role Specific Routes
|--------------------------------------------------------------------------
| আপনার রোল-ভিত্তিক রুট ফাইলগুলি আমদানি করা হচ্ছে
*/
require __DIR__ . '/auth.php';          // Laravel Breeze auth
require __DIR__ . '/superadmin.php';    // ✅ Superadmin Routes
require __DIR__ . '/depo.php';          // Depo Routes
require __DIR__ . '/distributor.php';   // Distributor Routes