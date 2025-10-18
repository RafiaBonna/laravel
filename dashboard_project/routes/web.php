// File: routes/web.php
<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <--- Auth ব্যবহার করার জন্য এটি প্রয়োজন

// ১. পাবলিক রুট (লগইন করা না থাকলে এটি দেখাবে)
Route::get('/', function () {
    // যদি কেউ লগইন করে থাকে, তবে তাকে তার রোল অনুযায়ী ড্যাশবোর্ডে পাঠানো হবে
    if (Auth::check()) {
        // Auth::user()->getDashboardRoute() ফাংশনটি User.php মডেলে সেট করা আছে
        return redirect(Auth::user()->getDashboardRoute());
    }
    // লগইন করা না থাকলে, welcome.blade.php দেখাবে
    return view('welcome');
})->name('home');


// ২. রোল-ভিত্তিক ড্যাশবোর্ড এবং Admin Panel Routes
// সব রুটকে 'auth' middleware এর মধ্যে রাখা হলো
Route::middleware(['auth'])->group(function () {
    
    // ----------------------------------------
    // A. ADMIN PANEL ROUTES
    // 'admin' middleware দিয়ে User Management সহ সব Admin কাজ সুরক্ষিত
    // ----------------------------------------
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');
        
        // User Management Routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user_id}', [UserController::class, 'update'])->name('users.edit');
        Route::post('/users/edit/store', [UserController::class, 'editStore'])->name('users.editStore');
        Route::post('/users/delete', [UserController::class, 'destroy'])->name('users.delete');
    });

    // ----------------------------------------
    // B. DISTRIBUTOR & DEPO DASHBOARD ROUTES
    // ----------------------------------------

    // Distributor Dashboard Route
    Route::get('/distributor/dashboard', [DashboardController::class, 'distributorIndex'])->name('distributor.dashboard');
    
    // Depo Dashboard Route
    Route::get('/depo/dashboard', [DashboardController::class, 'depoIndex'])->name('depo.dashboard');

});

// --- আপনার পুরোনো রুটগুলো এখন দরকার নেই, কারণ সব /admin/users এ গ্রুপ করা হয়েছে ---
// যেমন: Route::get('create', [UserController::class, 'create'])->name('create');
// এখন হবে: route('admin.users.create')