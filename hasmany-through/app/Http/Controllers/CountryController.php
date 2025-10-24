<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of all countries and their posts.
     */
    public function index()
    {
        // Eager load the 'posts' relationship (which is the HasManyThrough relationship) 
        // to avoid the N+1 problem.
        $countries = Country::with('posts')->get();

        // ডেটা স্ট্রাকচার দেখতে চাইলে:
        // return response()->json($countries);

        // আপনি ডেটা ভিউ-তে পাঠাতে পারেন:
        return view('countries.index', compact('countries'));
    }

    /**
     * Display a specific country and its posts.
     */
    public function show(string $id)
    {
        // 'posts' রিলেশনশিপ সহ নির্দিষ্ট Country খুঁজে বের করা
        $country = Country::with('posts')->findOrFail($id);
        
        // Country এর নাম
        $countryName = $country->name;
        
        // Has Many Through রিলেশনশিপের মাধ্যমে পাওয়া সমস্ত Post
        $posts = $country->posts; 

        // এখন আপনি $countryName এবং $posts ভিউ-তে ব্যবহার করতে পারেন।
        
        return view('countries.show', compact('country', 'posts'));
    }
}