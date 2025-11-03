<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the Supplier.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('superadmin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new Supplier.
     */
    public function create()
    {
        return view('superadmin.suppliers.create');
    }

    /**
     * Store a newly created Supplier in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
        ]);

        DB::beginTransaction();
        try {
            Supplier::create($request->only([
                'name', 'email', 'contact_name', 'contact_email'
            ]));

            DB::commit();
            return redirect()->route('superadmin.suppliers.index')->with('success', 'Supplier created successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Supplier creation failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified Supplier.
     */
    public function edit(Supplier $supplier)
    {
        return view('superadmin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified Supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('suppliers')->ignore($supplier->id)], 
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
        ]);
        
        DB::beginTransaction();
        try {
            $supplier->update($request->only([
                'name', 'email', 'contact_name', 'contact_email'
            ]));
            
            DB::commit();
            return redirect()->route('superadmin.suppliers.index')->with('success', 'Supplier updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Supplier update failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified Supplier from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('superadmin.suppliers.index')->with('success', 'Supplier deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Supplier deletion failed. Check for related records (e.g., Purchase Orders).');
        }
    }
}