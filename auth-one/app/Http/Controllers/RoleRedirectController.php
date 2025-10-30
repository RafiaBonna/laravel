<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    /**
     * লগইন করার পর ইউজারের রোল চেক করে তাকে তার নিজস্ব ড্যাশবোর্ডে পাঠাবে।
     */
    public function index()
    {
        // এই চেকটি 'auth' middleware হ্যান্ডেল করে, তবে সেফটির জন্য রাখা হলো।
        if (!Auth::check()) {
            return redirect('/login'); 
        }

        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard'); // Admin এর ড্যাশবোর্ড
            case 'vendor':
                return redirect()->route('vendor.dashboard'); // Vendor এর ড্যাশবোর্ড
            case 'customer':
            case 'rider':
            default:
                // Customer, Rider বা অন্য যেকোনো ডিফল্ট ইউজারের জন্য।
                // (redirect loop এড়ানোর জন্য এটি একটি নতুন/সাধারণ ড্যাশবোর্ড রুটে যাবে)
                return redirect()->route('user.dashboard'); 
        }
    }
}