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
    /**
     * Stock In List View
     * Route Name: stockin.index 
     */
    public function index()
    {
        // Fetch all Stock In transactions with related master data
        $stockIns = StockIn::with('rawMaterial', 'supplier')->latest()->get();
        return view('pages.stock_in.index', compact('stockIns')); 
    }

    /**
     * Product Receive Form
     * Route Name: stockin.create 
     */
    public function create()
    {
        // Form এর জন্য Raw Material এবং Supplier মাস্টার ডেটা লোড করা
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit', 'current_stock', 'alert_stock']);
        $suppliers = Supplier::all(['id', 'name']); 
        
        return view('pages.stock_in.create', compact('rawMaterials', 'suppliers'));
    }

    /**
     * Store Logic (Product Received Submission & Stock Update)
     * Route Name: stockin.store 
     */
    public function store(Request $request)
    {
        // ১. ইনপুট ডেটা ভ্যালিডেট করা
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'received_quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        // ২. ডেটাবেস ট্রানজ্যাকশন শুরু করা (যাতে কোনো এরর হলে পুরোটা বাতিল হয়ে যায়)
        DB::beginTransaction();

        try {
            // Raw Material Master ডেটা বের করা
            $material = RawMaterial::findOrFail($request->raw_material_id);

            // ৩. Stock In (transaction) টেবিল এ নতুন রেকর্ড তৈরি
            StockIn::create([
                'raw_material_id' => $request->raw_material_id, 
                'supplier_id' => $request->supplier_id,
                'received_quantity' => $request->received_quantity,
                'unit' => $material->unit, // Raw Material Master থেকে Unit নেওয়া হলো
                'unit_price' => $request->unit_price,
            ]);

            // ✅ ৪. Critical FIX: Raw Material Master টেবিল এ current_stock আপডেট করা
            $material->current_stock += $request->received_quantity;
            $material->save();

            // ৫. সব কাজ সফল হলে ট্রানজ্যাকশন নিশ্চিত করা
            DB::commit();

            return Redirect::route('stockin.index')->with('success', 'Material received and stock updated successfully!');

        } catch (\Exception $e) {
            // কোনো এরর হলে ট্রানজ্যাকশন বাতিল করা
            DB::rollBack();
            // \Log::error($e->getMessage()); // এরর লগ করার জন্য
            return Redirect::back()->withInput()->with('error', 'Failed to receive material. Please try again.');
        }
    }
    
    /**
     * View Invoice
     * Route Name: stockin.invoice 
     */
    public function invoice($id)
    {
        $stock = StockIn::with('rawMaterial', 'supplier')->findOrFail($id);
        return view('pages.stock_in.invoice', compact('stock'));
    }
}