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
            // dd($cats->toArray());
            return view('pages.index',compact('users'));// compact() is used when you want to pass multiple variables to a view.
    }


       public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {

        User::create($request->only([
            'name',
            'email',
            'password',
        ]));
        // dd($request->all());


        return Redirect::to('/');
    }

    public function update($user_id)
    {
        $users = User::find($user_id);
        return view('pages.edit',compact('users'));
    }


    public function editStore(Request $request)
    {
       $users = User::find($request->user_id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->save();
        return Redirect::to('/');
    }
    public function destroy(Request $request)
    {
        $users = User::find($request->user_id);
        $users->delete();
        return Redirect::to('/');
    }
}