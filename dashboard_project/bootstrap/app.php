<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // AdminMiddleware ইম্পোর্ট করা হলো

return Application::configure(basePath: dirname(__DIR__))->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)->withMiddleware(function (Middleware $middleware): void {
    // ✅ ফিক্স: AdminMiddleware কে 'admin' alias এ রেজিস্টার করা হলো
    $middleware->alias([
        'admin' => AdminMiddleware::class,
    ]);
})->withExceptions(function (Exceptions $exceptions): void {
    //
})->create();