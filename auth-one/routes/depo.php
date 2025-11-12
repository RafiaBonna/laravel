<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use App\Http\Controllers\Depo\SalesApprovalController; // ⬅️ NEW IMPORT
use Illuminate\Support\Facades\Route;

Route::prefix('depo')->group(function () {
    Route::middleware(['auth', 'role:depo'])->group(function () {
        
        // Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // 🚛 SALES APPROVAL & VIEW (NEW SECTION)
        Route::prefix('invoices')->controller(SalesApprovalController::class)->name('depo.invoices.')->group(function () {
            // Depo দেখবে এমন সব ইনভয়েস
            Route::get('/', 'index')->name('index'); 
            Route::get('/pending', 'pending')->name('pending'); // শুধু Pending ইনভয়েস
            Route::get('/{salesInvoice}', 'show')->name('show'); // ইনভয়েস বিস্তারিত
            
            // 🟢 Approval Action (স্টক কমানো হবে)
            Route::post('/{salesInvoice}/approve', 'approve')->name('approve'); 
            
            // 🔴 Cancellation Action (স্টক কমবে না)
            Route::post('/{salesInvoice}/cancel', 'cancel')->name('cancel'); 
        });

        
    });
});