<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    /**
     * Vendor Dashboard-এর মূল পেজ দেখাবে।
     */
    public function index()
    {
        // নিশ্চিত করুন resources/views/vendor/dashboard.blade.php ফাইলটি তৈরি আছে।
        return view('vendor.dashboard'); 
    }
}