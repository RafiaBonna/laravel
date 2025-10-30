<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    public function index()
    {
        // যদি কেউ লগইন না করে /dashboard এ আসতে চায়
        if (!Auth::check()) {
            return redirect('/login'); 
        }

        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'vendor':
                return redirect()->route('vendor.dashboard');
            default:
                // Customer, Rider বা অন্যান্য ডিফল্ট ইউজারের জন্য
                return redirect('/dashboard'); 
        }
    }
}