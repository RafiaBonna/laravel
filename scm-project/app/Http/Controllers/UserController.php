<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    // ✅ Show all users (route: /users)
    public function index()
    {
        $users = User::all();
        return view('pages.user.view', compact('users'));
    }

    // ✅ Show the user creation form (route: /add-user)
    public function create()
    {
        return view('pages.user.add-user');
    }

    // ✅ Store a new user (route: POST /userStore)
    public function store(Request $request)
    {
        // Validation (optional but recommended)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // You can later hash it if needed
        ]);

        // Redirect back to the users list
        return Redirect::route('user.view');
    }

    // ✅ Delete a user (route: DELETE /delete)
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        return Redirect::route('user.index');
    }

    // ✅ Show edit form (route: GET /userEdit/{user_id})
    public function update($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('pages.user.edit', compact('user'));
    }

    // ✅ Update user info (route: POST /editStoreU)
    public function editStoreU(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return Redirect::route('user.index');
    }
}