<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Admin Dashboard-এর মূল পেজ দেখাবে।
     */
    public function index()
    {
        // নিশ্চিত করুন resources/views/admin/dashboard.blade.php ফাইলটি তৈরি আছে।
        return view('admin_panel.dashboard'); 
    }
}