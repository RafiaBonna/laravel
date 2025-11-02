<?php
// app/Http/Controllers/Superadmin/RawMaterialController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the Raw Materials (Raw Materials List).
     */
    public function index()
    {
        $rawMaterials = RawMaterial::all();
        // View: superadmin/raw_materials/index.blade.php
        return view('superadmin.raw_materials.index', compact('rawMaterials'));
    }

    /**
     * Show the form for creating a new Raw Material.
     */
    public function create()
    {
        $units = ['kg', 'pcs', 'liter', 'grams', 'unit']; 
        // View: superadmin/raw_materials/create.blade.php
        return view('superadmin.raw_materials.create', compact('units'));
    }

    /**
     * Store a newly created Raw Material in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:raw_materials,name',
            'unit' => 'required|string|max:50',
            'alert_stock' => 'required|numeric|min:0', 
        ]);

        DB::beginTransaction();
        try {
            RawMaterial::create([
                'name' => $request->name,
                'unit' => $request->unit,
                'alert_stock' => $request->alert_stock,
                'current_stock' => 0, // নতুন ম্যাটেরিয়ালের স্টক ০ দিয়ে শুরু হবে
            ]);

            DB::commit();
            return redirect()->route('superadmin.raw_materials.index')->with('success', 'Raw Material added successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Raw Material creation failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified Raw Material.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        $units = ['kg', 'pcs', 'liter', 'grams', 'unit']; 
        // View: superadmin/raw_materials/edit.blade.php
        return view('superadmin.raw_materials.edit', compact('rawMaterial', 'units'));
    }

    /**
     * Update the specified Raw Material in storage.
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:raw_materials,name,' . $rawMaterial->id,
            'unit' => 'required|string|max:50',
            'alert_stock' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        try {
            // শুধুমাত্র নাম, ইউনিট এবং অ্যালার্ট স্টক আপডেট হবে। স্টক স্টক-ইন/আউট দ্বারা নিয়ন্ত্রিত হবে।
            $rawMaterial->update($request->only(['name', 'unit', 'alert_stock']));
            
            DB::commit();
            return redirect()->route('superadmin.raw_materials.index')->with('success', 'Raw Material updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Raw Material update failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified Raw Material from storage.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        try {
            $rawMaterial->delete();
            return redirect()->route('superadmin.raw_materials.index')->with('success', 'Raw Material deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Raw Material deletion failed. Check for related records.');
        }
    }
}