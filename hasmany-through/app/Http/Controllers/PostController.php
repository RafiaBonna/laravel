<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User; // User মডেল লাগবে 
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource and the creation form.
     */
    public function index()
    {
        // ১. HasManyThrough রিলেশনশিপের মাধ্যমে ডেটা আনা
        // এই ক্ষেত্রে, আমরা সব পোস্টকেই নিয়ে আসব এবং তার User ও Country Eager Load করব।
        // যাতে টেবিলের মধ্যে পোস্টের ইউজার এবং দেশের নাম দেখানো যায়।
        $posts = Post::with('user.country')->latest()->get();
        
        // ফর্মের জন্য সব ইউজারকে দরকার, যাতে ড্রপডাউন-এ ইউজার সিলেক্ট করা যায়
        $users = User::all();

        // ভিউ-তে ডেটা পাঠানো
        return view('posts.index', compact('posts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ২. ফর্ম থেকে ডেটা ভ্যালিডেট করা
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        // ৩. ডেটাবেসে পোস্ট তৈরি করা
        Post::create($request->all());

        // ৪. সফল হওয়ার পর index পেজে রিডাইরেক্ট করা
        return redirect()->route('posts.index')->with('success', 'Post successfully created!');
    }
}