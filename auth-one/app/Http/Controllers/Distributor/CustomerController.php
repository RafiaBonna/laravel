<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the Customers managed by the current Distributor.
     */
    public function index()
    {
        $distributorId = auth()->user()->distributor->id ?? null;
        
        if (!$distributorId) {
             return view('distributor.customers.index', ['customers' => collect()]);
        }
        
        $customers = Customer::where('distributor_id', $distributorId)->get();
        return view('distributor.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new Customer.
     */
    public function create()
    {
        return view('distributor.customers.create');
    }

    /**
     * Store a newly created Customer in storage.
     */
    public function store(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers', 
        ]);

        // ২. লগইন করা Distributor-এর আইডি সংগ্রহ
        $distributor = auth()->user()->distributor;
        
        if (!$distributor) { 
            return redirect()->back()->with('error', 'Error: Distributor link not found for your user account.')->withInput(); 
        }
        
        DB::beginTransaction();
        try {
            // ৩. Customer তৈরি এবং distributor_id যোগ
            Customer::create([
                'distributor_id' => $distributor->id, // ✅ Distributor ID সেভ করা হচ্ছে
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            DB::commit();
            return redirect()->route('distributor.customers.index')->with('success', 'Customer created successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Customer creation failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified Customer.
     */
    public function edit(Customer $customer)
    {
        // নিশ্চিত করুন যে শুধুমাত্র নিজের কাস্টমারকেই এডিট করা যাবে
        if ($customer->distributor_id !== auth()->user()->distributor->id) { return abort(403); }
        return view('distributor.customers.edit', compact('customer'));
    }

    /**
     * Update the specified Customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        if ($customer->distributor_id !== auth()->user()->distributor->id) { return abort(403); }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', Rule::unique('customers')->ignore($customer->id)],
        ]);
        
        DB::beginTransaction();
        try {
            $customer->update([
                'name' => $request->name, 
                'phone' => $request->phone
            ]);
            DB::commit();
            return redirect()->route('distributor.customers.index')->with('success', 'Customer updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Customer update failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified Customer from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->distributor_id !== auth()->user()->distributor->id) { return abort(403); }
        
        try {
            $customer->delete();
            return redirect()->route('distributor.customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Customer deletion failed.');
        }
    }
}