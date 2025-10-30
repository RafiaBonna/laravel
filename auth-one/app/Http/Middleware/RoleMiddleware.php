<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- এটি আবশ্যক

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // যদি ইউজার লগইন না করে থাকে বা তার role, চাওয়া role এর সমান না হয়, তবে 403 error দেবে।
        if (!Auth::check() || $request->user()->role !== $role) {
            return abort(403, 'Unauthorized action. You do not have the required role.');
        }

        return $next($request);
    }
}