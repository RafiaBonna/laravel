<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        // 'index' er bodole 'pages.index' dewa holo
        return view('pages.index', compact('users')); 
    }

    public function create()
    {
        // 'create' er bodole 'pages.create' dewa holo
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
        ]);
        
        User::create($request->only([
            'name',
            'email',
            'password', 
        ]));
        
        return Redirect::to('/');
    }

    public function update($user_id)
    {
        $user = User::findOrFail($user_id); 
        // 'edit' er bodole 'pages.edit' dewa holo
        return view('pages.edit', compact('user'));
    }

    public function editStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        
        $user = User::findOrFail($request->user_id); 
        
        $user->name = $request->name;
        $user->email = $request->email; 
        
        if ($request->password) {
            $user->password = $request->password; 
        }

        $user->save();
        return Redirect::to('/');
    }
    
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id); 
        $user->delete();
        return Redirect::to('/');
    }
}