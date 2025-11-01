<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'depo':
                return redirect()->route('depo.dashboard');
            case 'distributor':
                return redirect()->route('distributor.dashboard');
            case 'superadmin': // ✅ CRITICAL: সবার উপরে নতুন Superadmin রোলের চেক
                return redirect()->route('superadmin.dashboard');
            default:
                return redirect()->route('user.dashboard'); 
        }
    }
}
