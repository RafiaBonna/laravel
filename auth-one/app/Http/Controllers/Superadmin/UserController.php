<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Depo;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Transaction-এর জন্য

class UserController extends Controller
{
    /**
     * User-দের তালিকা দেখায়। (R - Read)
     */
    public function index()
    {
        // Superadmin ইউজার ছাড়া বাকি ইউজারদের লোড করা হচ্ছে
        $users = User::with(['roles', 'depo', 'distributor.depo'])
                    ->whereDoesntHave('roles', function ($query) {
                        $query->where('slug', 'superadmin');
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    /**
     * নতুন ইউজার তৈরির ফর্ম দেখায়। (C - Create Form)
     */
    public function create()
    {
        // Superadmin রোল ছাড়া বাকি রোলগুলো লোড করা
        $roles = Role::where('slug', '!=', 'superadmin')->get();
        $depos = Depo::all();
        
        return view('superadmin.users.create', compact('roles', 'depos'));
    }

    /**
     * নতুন ইউজারকে সিস্টেমে সংরক্ষণ করে। (C - Create Store)
     */
    public function store(Request $request)
    {
        // ১. ডেটা ভ্যালিডেশন
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'], 
            'status' => ['required', 'in:active,inactive'],
            'location' => ['nullable', 'string', 'max:255'],
            'distributor_depo_id' => [
                'nullable', 
                Rule::requiredIf(fn () => Role::find($request->role_id)?->slug === 'distributor'), 
                'exists:depos,id'
            ],
        ]);

        // ২. ট্রানজাকশন শুরু করা
        DB::beginTransaction();
        try {
            // A. Role Slug বের করুন
            $role = Role::find($validatedData['role_id']);
            $roleSlug = $role->slug;
            
            // B. users টেবিলে নতুন User তৈরি করুন 
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'status' => $validatedData['status'],
            ]);

            // C. role_user টেবিলে Role অ্যাসাইন করুন
            $user->roles()->attach($role->id);

            // D. প্রোফাইল ডেটা (Entity) তৈরি করুন
            if ($roleSlug === 'depo') {
                Depo::create([
                    'user_id' => $user->id,
                    'name' => $validatedData['name'] . ' Depo',
                    'location' => $validatedData['location'] ?? 'N/A',
                ]);
            } elseif ($roleSlug === 'distributor') {
                Distributor::create([
                    'user_id' => $user->id,
                    'depo_id' => $validatedData['distributor_depo_id'],
                    'name' => $validatedData['name'] . ' Distributor',
                    'location' => $validatedData['location'] ?? 'N/A',
                ]);
            }
            
            // ৩. সফল হলে কমিট
            DB::commit();

            return redirect()->route('superadmin.users.index')
                ->with('success', 'User (' . ucfirst($roleSlug) . ') created successfully.');

        } catch (\Exception $e) {
            // ৪. ব্যর্থ হলে রোলব্যাক এবং লগ
            DB::rollBack();
            \Log::error('Superadmin User Creation Failed: ' . $e->getMessage()); 

            return back()->with('error', 'User creation failed. Check logs for details.')->withInput();
        }
    }

    /**
     * নির্দিষ্ট ইউজারকে এডিট করার ফর্ম দেখায়। (U - Update Form)
     */
    public function edit(User $user)
    {
        if ($user->hasRole('superadmin')) {
            return back()->with('error', 'Superadmin user cannot be edited from this interface.');
        }

        $roles = Role::where('slug', '!=', 'superadmin')->get();
        $depos = Depo::all();

        // ইউজারটির বর্তমান Depo বা Distributor ডেটা লোড করা
        $user->load(['roles', 'depo', 'distributor']);
        
        return view('superadmin.users.edit', compact('user', 'roles', 'depos'));
    }

    /**
     * নির্দিষ্ট ইউজারকে আপডেট করে। (U - Update Store)
     */
    public function update(Request $request, User $user)
    {
        if ($user->hasRole('superadmin')) {
             return back()->with('error', 'Cannot update Superadmin user from here.');
        }

        // ১. ভ্যালিডেশন
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // ইমেইল শুধু নিজের না হলে unique হবে
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'], 
            'status' => ['required', 'in:active,inactive'],
            'location' => ['nullable', 'string', 'max:255'],
            'distributor_depo_id' => [
                'nullable', 
                Rule::requiredIf(fn () => Role::find($request->role_id)?->slug === 'distributor'), 
                'exists:depos,id'
            ],
        ]);

        // ২. ট্রানজাকশন শুরু
        DB::beginTransaction();
        try {
            $role = Role::find($validatedData['role_id']);
            $newRoleSlug = $role->slug;
            
            // A. users টেবিলে User ডেটা আপডেট করা
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'status' => $validatedData['status'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            ]);

            // B. role_user টেবিলে Role আপডেট করা
            $user->roles()->sync([$role->id]);
            
            // C. প্রোফাইল ডেটা (Entity) আপডেট করা
            $this->handleEntityUpdate($user, $newRoleSlug, $request);

            DB::commit();

            return redirect()->route('superadmin.users.index')
                ->with('success', 'User (' . ucfirst($newRoleSlug) . ') updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Superadmin User Update Failed: ' . $e->getMessage()); 
            return back()->with('error', 'User update failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * নির্দিষ্ট ইউজারকে ডিলিট করে। (D - Delete)
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('superadmin')) {
            return back()->with('error', 'Cannot delete the Superadmin user.');
        }

        try {
            // onDelete('cascade') এর কারণে Depo/Distributor রেকর্ডগুলো স্বয়ংক্রিয়ভাবে ডিলিট হয়ে যাবে
            $user->delete();
            return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    /**
     * Helper function to handle entity (Depo/Distributor) creation/deletion/update.
     */
    protected function handleEntityUpdate(User $user, string $newRoleSlug, Request $request)
    {
        // পুরনো Depo/Distributor ডেটা মুছে ফেলা
        $user->depo()->delete();
        $user->distributor()->delete();

        if ($newRoleSlug === 'depo') {
            // নতুন Depo রেকর্ড তৈরি করা
            Depo::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Depo',
                'location' => $request->location ?? 'N/A',
            ]);
        } elseif ($newRoleSlug === 'distributor') {
            // নতুন Distributor রেকর্ড তৈরি করা
            Distributor::create([
                'user_id' => $user->id,
                'depo_id' => $request->distributor_depo_id,
                'name' => $user->name . ' Distributor',
                'location' => $request->location ?? 'N/A',
            ]);
        }
    }
}