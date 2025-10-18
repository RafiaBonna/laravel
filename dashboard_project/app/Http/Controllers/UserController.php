<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; // Auth ইম্পোর্ট করা হলো

class UserController extends Controller
{
    /**
     * নতুন ইউজার যোগ করার আগে, এই কন্ট্রোলারের কনস্ট্রাক্টরে নিশ্চিত করা হলো যে
     * শুধুমাত্র লগইন করা 'admin' রোল ইউজাররাই ইউজার CRUD করতে পারবে।
     */
    public function __construct()
    {
        // CRUD ফাংশনগুলো admin middleware দ্বারা সুরক্ষিত করা হলো
        $this->middleware('auth'); 
        $this->middleware('role:admin'); 
    }

     // সকল ইউজারকে দেখানো হবে (নতুন রুট: admin.users.index)
     public function index()
     {
        // নিশ্চিত করুন যে শুধুমাত্র অ্যাডমিনরাই এই পেজটি দেখতে পাবে (যদিও middleware আছে, কোডটা পরিষ্কার থাকা ভালো)
        if (Auth::user()->role !== 'admin') {
            return Redirect::to('/'); // যদি কেউ ভুল করে চলে আসে, হোমে রিডাইরেক্ট করে দেবে
        }
           $users = User::all();
           // view('pages.user.index') আপনার ব্লেড ফাইলের পাথের উপর ভিত্তি করে
           return view('pages.user.index', compact('users')); 
    }


    // ইউজার তৈরি করার ফর্ম দেখাবে (নতুন রুট: admin.users.create)
    public function create()
    {
        return view('pages.user.create');
    }

    // নতুন ইউজার ডাটাবেসে স্টোর করবে
    public function store(Request $request)
    {
        // Validation যোগ করা যেতে পারে। 
        
        // পাসওয়ার্ড হ্যাশ করে স্টোর করা
        $data = $request->only('name', 'email', 'role');
        $data['password'] = Hash::make($request->password);
        
        User::create($data);

        // সফলভাবে স্টোর করার পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
        return Redirect::route('admin.users.index')->with('success', 'User created successfully!');
    }

    // ইউজার এডিট ফর্ম দেখাবে (নতুন রুট: admin.users.edit)
    public function update($user_id)
    {
        $users = User::findOrFail($user_id);
        return view('pages.user.edit', compact('users'));
    }


    // এডিট করা ইউজার ডাটাবেসে স্টোর করবে
    public function editStore(Request $request)
    {
       $users = User::findOrFail($request->user_id);
       $users->name = $request->name;
       $users->email = $request->email;
       // শুধুমাত্র তখনই পাসওয়ার্ড আপডেট করা হবে, যখন ইউজার নতুন পাসওয়ার্ড দেবে
       if (!empty($request->password)) {
           $users->password = Hash::make($request->password);
       }
       // রোল আপডেট করার অপশন থাকলে সেটাও যোগ করা যেতে পারে
       if ($request->has('role')) {
           $users->role = $request->role;
       }
       
       $users->save();
       
       // সফলভাবে আপডেটের পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
       return Redirect::route('admin.users.index')->with('success', 'User updated successfully!');
    }
    
    // ইউজার ডিলিট করবে
    public function destroy(Request $request)
    {
        $users = User::findOrFail($request->user_id);
        $users->delete();
        
        // সফলভাবে ডিলিটের পর অ্যাডমিন ইউজার লিস্টে রিডাইরেক্ট করা হলো।
        return Redirect::route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
