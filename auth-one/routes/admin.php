<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // অন্যান্য admin routes এখানে
    // Route::resource('/categories', CategoryController::class);
});
