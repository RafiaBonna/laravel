<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // Auth ইম্পোর্ট করা হলো

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * লগইন সফল হলে ইউজারকে তার রোলের ড্যাশবোর্ড রুটে পাঠানো হবে।
     *
     * @return string
     */
    protected function redirectTo()
    {
        // ✅ ফিক্স: এখানে Null Check যোগ করা হলো
        if (Auth::check()) {
            // যদি ইউজার লগইন করা থাকে, তবেই getDashboardRoute() কল করা হবে।
            return Auth::user()->getDashboardRoute();
        }

        // যদি কোনো কারণে চেক ব্যর্থ হয় বা ইউজার না থাকে, তবে নিরাপদভাবে /login রুটে ফেরত পাঠানো হবে
        return '/login'; 
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}