<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // চেক করা হচ্ছে ইউজার লগইন করা আছে কিনা
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'প্রথমে লগইন করুন।');
        }
        
        // ইউজার রোল 'admin' কিনা চেক করা হচ্ছে
        if (Auth::user()->role === 'admin') {
            return $next($request); // যদি admin হয়, তবে পরের ধাপে যাও
        }

        // admin না হলে, তাকে হোমপেজে ফেরত পাঠাও এবং একটি এরর মেসেজ দেখাও
        return redirect('/')->with('error', 'আপনার অ্যাডমিন অ্যাক্সেস নেই।');
    }
}