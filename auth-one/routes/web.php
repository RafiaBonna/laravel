<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRedirectController;

/*
|--------------------------------------------------------------------------
| Default Route → Login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Role Based Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [RoleRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| General User Dashboard
|--------------------------------------------------------------------------
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
| Logout Route
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Include Role Specific Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';         // Laravel Breeze auth
require __DIR__ . '/superadmin.php';   // ✅ নতুন Superadmin রুট যুক্ত করুন
require __DIR__ . '/depo.php';         // Depo routes
require __DIR__ . '/distributor.php';  // Distributor routes
