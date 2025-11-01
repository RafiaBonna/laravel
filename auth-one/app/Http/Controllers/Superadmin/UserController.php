<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Depo;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // শুধুমাত্র Depo এবং Distributor রোলগুলোর ইউজারদের দেখানো হচ্ছে
        $users = User::whereIn('role', ['depo', 'distributor'])->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $depos = Depo::all(); 
        return view('superadmin.users.create', compact('depos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['depo', 'distributor'])],
            // role যদি distributor হয়, তবে depo_id আবশ্যক
            'depo_id' => 'nullable|required_if:role,distributor|exists:depos,id', 
        ]);

        DB::beginTransaction();
        try {
            // ১. User তৈরি (Models-এ role এবং status fillable আছে ধরে নেওয়া হচ্ছে)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => 'active', 
            ]);

            // ২. রোল অনুযায়ী Depo/Distributor রেকর্ড তৈরি
            if ($user->role === 'depo') {
                Depo::create([
                    'user_id' => $user->id, // user_id fillable থাকতে হবে
                    'name' => $user->name
                ]);
            } elseif ($user->role === 'distributor') {
                Distributor::create([
                    'user_id' => $user->id, // user_id fillable থাকতে হবে
                    'name' => $user->name, 
                    'depo_id' => $request->depo_id // depo_id fillable থাকতে হবে
                ]);
            }

            DB::commit();
            return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'User creation failed: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit(User $user)
    {
        if (!in_array($user->role, ['depo', 'distributor'])) { return abort(403); }
        $depos = Depo::all(); 
        return view('superadmin.users.edit', compact('user', 'depos'));
    }

    public function update(Request $request, User $user) 
    { 
        if (!in_array($user->role, ['depo', 'distributor'])) { return abort(403); }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['depo', 'distributor'])],
            'depo_id' => 'nullable|required_if:role,distributor|exists:depos,id',
        ]);

        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) { $user->password = Hash::make($request->password); }
            $user->save();

            // নাম আপডেট করুন
            if ($user->role === 'depo' && $user->depo) {
                $user->depo()->update(['name' => $user->name]);
            } elseif ($user->role === 'distributor' && $user->distributor) {
                $user->distributor()->update(['name' => $user->name, 'depo_id' => $request->depo_id]);
            }

            DB::commit();
            return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'User update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        if (!in_array($user->role, ['depo', 'distributor'])) { return abort(403); }
        
        try {
            $user->delete();
            return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User deletion failed.');
        }
    }
}