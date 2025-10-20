<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\RawMaterial; 
use App\Models\Supplier;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockInController extends Controller
{
    // ✅ Stock In Sub-menu (Transaction List View)
    // Route Name: raw_material.stockin.index
    public function index()
    {
        // Fetch all Stock In transactions with related master data
        $stockIns = StockIn::with('rawMaterial', 'supplier')->latest()->get();
        // View Path: pages/raw_material/stockin/view.blade.php
        return view('pages.raw_material.stockin.view', compact('stockIns')); 
    }

    // ✅ Product Received Sub-menu (Receive Form)
    // Route Name: raw_material.product_received.create
    public function create()
    {
        // Form এর জন্য Raw Material এবং Supplier মাস্টার ডেটা লোড করা
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit', 'current_stock', 'alert_stock']);
        $suppliers = Supplier::all(['id', 'name']); 
        
        // View Path: pages/raw_material/stockin/add-stockin.blade.php
        return view('pages.raw_material.stockin.add-stockin', compact('rawMaterials', 'suppliers'));
    }

    // ✅ Store Logic (Product Received Submission & Stock Update)
    // Route Name: raw_material.stockin.store
    public function store(Request $request)
    {
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'received_quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

   
        //data intregration transaction start here
        DB::beginTransaction();

        try {
            $material = RawMaterial::findOrFail($request->raw_material_id);

            // ১. stock_ins (transaction) table record
            StockIn::create([
                'raw_material_id' => $request->raw_material_id, 
                'supplier_id' => $request->supplier_id,
                'received_quantity' => $request->received_quantity,
                'unit' => $material->unit, // take unti from Master 
                'unit_price' => $request->unit_price,
            ]);

            // ২. raw_materials (master) table update  current_stock
            $material->current_stock += $request->received_quantity;
            $material->save();

            DB::commit();

            return Redirect::route('raw_material.stockin.index')->with('success', 'Material received and stock updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with('error', 'Failed to receive material. Please try again.');
        }
    }
}