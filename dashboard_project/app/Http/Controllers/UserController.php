<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Hash; // Hash এখানে প্রয়োজন নেই কারণ এটি Model-এ casts করা হয়েছে

class UserController extends Controller
{
     public function index()
     {
           $users = User::all();
            return view('pages.user.index',compact('users'));
    }


       public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        // 'role' field যোগ করা হলো
        User::create($request->only([
            'name',
            'email',
            'password',
            'role', // <--- এখানে role যোগ করা হলো
        ]));

        // ইউজার লিস্ট পেজে রিডাইরেক্ট করা হলো
        return Redirect::to('/users'); 
    }

    public function update($user_id)
    {
        $users = User::find($user_id);
        return view('pages.user.edit',compact('users'));
    }


    public function editStore(Request $request)
    {
       $users = User::find($request->user_id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->role = $request->role; // <--- এখানেও role যোগ করা হলো
        $users->save();
        
        // ইউজার লিস্ট পেজে রিডাইরেক্ট করা হলো
        return Redirect::to('/users'); 
    }
    public function destroy(Request $request)
    {
        $users = User::find($request->user_id);
        $users->delete();
        // ইউজার লিস্ট পেজে রিডাইরেক্ট করা হলো
        return Redirect::to('/users'); 
    }
}