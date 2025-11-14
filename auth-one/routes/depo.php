<?php

use App\Http\Controllers\Depo\DepoDashboardController;
use App\Http\Controllers\Depo\SalesApprovalController;
use Illuminate\Support\Facades\Route;

Route::prefix('depo')->group(function () {
    Route::middleware(['auth', 'role:depo'])->group(function () {

        // Dashboard Route
        Route::get('/dashboard', [DepoDashboardController::class, 'index'])->name('depo.dashboard');

        // SALES APPROVAL & VIEW
        // Route name prefix → depo.invoices.*
        Route::prefix('invoices')->controller(SalesApprovalController::class)->name('depo.invoices.')->group(function () {
            // All invoices visible to Depo
            Route::get('/', 'index')->name('index');
            Route::get('/pending', 'pending')->name('pending'); // Only Pending Invoices
            Route::get('/{salesInvoice}', 'show')->name('show'); // Invoice Details

            // Approval Action (deduct stock)
            Route::post('/{salesInvoice}/approve', 'approve')->name('approve');

            // Cancellation Action (no stock deduction)
            Route::post('/{salesInvoice}/cancel', 'cancel')->name('cancel');
        });


    });
});