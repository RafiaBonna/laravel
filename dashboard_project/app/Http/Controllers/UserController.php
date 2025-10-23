<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * শুধুমাত্র লগইন করা 'admin' রোল ইউজাররাই ইউজার CRUD করতে পারবে।
     */
    public function __construct()
    {
        // 'auth' এবং 'admin' alias middleware দ্বারা CRUD ফাংশনগুলো সুরক্ষিত করা হলো
        $this->middleware('auth'); 
        $this->middleware('admin'); 
    }

     // সকল ইউজারকে দেখানো হবে (রুট: admin.users.index)
     public function index()
     {
        // নিরাপত্তা নিশ্চিত করার জন্য এটি রাখা হলো।
        if (Auth::user()->role !== 'admin') {
            return Redirect::to('/'); 
        }
           $users = User::all();
           
           // ✅ ফিক্স: ভিউ পাথ 'pages.user.index' থেকে 'users.index' এ পরিবর্তন করা হলো।
           return view('users.index', compact('users')); 
    }


    // ইউজার তৈরি করার ফর্ম দেখাবে (রুট: admin.users.create)
    public function create()
    {
        // ✅ ফিক্স: ভিউ পাথ 'pages.user.create' থেকে 'users.create' এ পরিবর্তন করা হলো।
        return view('users.create');
    }

    // নতুন ইউজার ডাটাবেসে স্টোর করবে
    public function store(Request $request)
    {
       $validatedData = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:8',
           'role' => 'required|in:admin,distributor,depo', // রোল ভ্যালিডেশন
       ]);
       
       User::create([
           'name' => $validatedData['name'],
           'email' => $validatedData['email'],
           'password' => Hash::make($validatedData['password']),
           'role' => $validatedData['role']
       ]);
       
       // সফলভাবে ক্রিয়েট-এর পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
       return Redirect::route('admin.users.index')->with('success', 'User created successfully!');
    }

    // ইউজার এডিট ফর্ম দেখাবে (রুট: admin.users.edit)
    // ⚠️ ফিক্স: মেথডের নাম update থেকে edit করা হলো
    public function edit($user_id)
    {
        $users = User::findOrFail($user_id);
        // ✅ ফিক্স: ভিউ পাথ 'pages.user.edit' থেকে 'users.edit' এ পরিবর্তন করা হলো।
        return view('users.edit', compact('users'));
    }


    // এডিট করা ইউজার ডাটাবেসে স্টোর করবে (রুট: admin.users.editStore)
    public function editStore(Request $request)
    {
       $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user_id, // ইমেইল ইউনিক ভ্যালিডেশন
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,distributor,depo',
        ]);
        
       $users = User::findOrFail($request->user_id);
       $users->name = $request->name;
       $users->email = $request->email;
       // শুধুমাত্র তখনই পাসওয়ার্ড আপডেট করা হবে, যখন ইউজার নতুন পাসওয়ার্ড দেবে
       if (!empty($request->password)) {
           $users->password = Hash::make($request->password);
       }
       // রোল আপডেট
       $users->role = $request->role;
       
       $users->save();
       
       // সফলভাবে আপডেটের পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
       return Redirect::route('admin.users.index')->with('success', 'User updated successfully!');
    }
    
    // ইউজার ডিলিট করবে (রুট: admin.users.delete)
    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $users = User::findOrFail($request->user_id);
        $users->delete();
        
        // সফলভাবে ডিলিটের পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
        return Redirect::route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}