<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        // এই ফাংশনটি আপনার User.php মডেলে সেট করা getDashboardRoute() ফাংশনটিকে কল করবে।
        return \Auth::user()->getDashboardRoute();
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