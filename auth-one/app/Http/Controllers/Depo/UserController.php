<?php

namespace App\Http\Controllers\Depo;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $targetRole = 'distributor';
    
    /**
     * Display a listing of Distributors under the current Depo.
     */
    public function index() // ✅ index() মেথডটি নিশ্চিত করা হলো
    {
        // লগইন করা Depo Manager-এর depo_id বের করা
        $depoId = auth()->user()->depo->id ?? null;
        
        if (!$depoId) {
             return view('depo.users.index', ['users' => collect()]);
        }
        
        // এই Depo-এর সাথে সম্পর্কিত Distributor ইউজারদের লোড করা হচ্ছে
        $users = User::whereHas('distributor', function ($query) use ($depoId) {
            $query->where('depo_id', $depoId);
        })->get();

        return view('depo.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new Distributor.
     */
    public function create()
    {
        return view('depo.users.create');
    }

    /**
     * Store a newly created Distributor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $depo = auth()->user()->depo; 
        if (!$depo) { return redirect()->back()->with('error', 'Depo record not found. Cannot create Distributor.')->withInput(); }
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => Hash::make($request->password), 
                'role' => $this->targetRole, 
                'status' => 'active',
            ]);
            
            Distributor::create([ // Mass Assignment ফিক্সড
                'user_id' => $user->id, 
                'depo_id' => $depo->id, 
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('depo.users.index')->with('success', 'Distributor created successfully.');
        
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Distributor creation failed: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Show the form for editing the specified Distributor.
     */
    public function edit(User $user)
    {
        if ($user->role !== $this->targetRole || $user->distributor->depo_id !== auth()->user()->depo->id) { return abort(403); }
        return view('depo.users.edit', compact('user'));
    }

    /**
     * Update the specified Distributor in storage.
     */
    public function update(Request $request, User $user) 
    {
        if ($user->role !== $this->targetRole || $user->distributor->depo_id !== auth()->user()->depo->id) { return abort(403); }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) { $user->password = Hash::make($request->password); }
            $user->save();

            $user->distributor()->update(['name' => $user->name]);
            
            DB::commit();
            return redirect()->route('depo.users.index')->with('success', 'Distributor updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Distributor update failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified Distributor from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role !== $this->targetRole || $user->distributor->depo_id !== auth()->user()->depo->id) { return abort(403); }
        
        try {
            $user->delete();
            return redirect()->route('depo.users.index')->with('success', 'Distributor deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Distributor deletion failed.');
        }
    }
}