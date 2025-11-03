<?php
// app/Http/Controllers/Superadmin/RawMaterialReceivingController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\RawMaterialReceiving;
use App\Models\StockMovement; 
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class RawMaterialReceivingController extends Controller
{
    /**
     * Display a listing of the receivings (List of Invoices).
     */
    public function index()
    {
        // ইনভয়েসগুলো লোড করা 
        $receivings = RawMaterialReceiving::with(['rawMaterial', 'supplier', 'user'])->latest()->get();
        return view('superadmin.raw_material_receivings.index', compact('receivings'));
    }

    /**
     * Show the form for creating a new receiving record (Stock In Form).
     */
    public function create()
    {
        // ফর্মের জন্য প্রয়োজনীয় Raw Material এবং Supplier-দের ডেটা লোড করা
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit']);
        $suppliers = Supplier::all(['id', 'name']); 
        
        return view('superadmin.raw_material_receivings.create', compact('rawMaterials', 'suppliers'));
    }

    /**
     * Store a newly created receiving record AND update stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:raw_material_receivings,invoice_number',
            'supplier_id' => 'required|exists:suppliers,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_cost' => 'required|numeric|min:0',
            'receiving_date' => 'required|date|before_or_equal:today',
        ]);

        // CRITICAL: Database Transaction শুরু
        DB::beginTransaction();
        try {
            // ১. Raw Material Receiving Record তৈরি (Invoice Detail)
            $receiving = RawMaterialReceiving::create([
                'invoice_number' => $request->invoice_number,
                'supplier_id' => $request->supplier_id,
                'raw_material_id' => $request->raw_material_id,
                'quantity' => $request->quantity,
                'unit_cost' => $request->unit_cost,
                'receiving_date' => $request->receiving_date,
                'user_id' => Auth::id(), // যিনি রিসিভ করছেন
            ]);

            // ২. Stock Movement Record তৈরি (Stock In History)
            StockMovement::create([
                'raw_material_id' => $request->raw_material_id,
                'type' => 'IN', // IN মুভমেন্ট
                'quantity' => $request->quantity,
                'reference_type' => RawMaterialReceiving::class, // উৎস: এই রিসিভিং ডকুমেন্ট
                'reference_id' => $receiving->id,
                'user_id' => Auth::id(),
            ]);

            // ৩. Raw Material এর বর্তমান স্টক আপডেট করা (Master Table Update)
            $rawMaterial = RawMaterial::findOrFail($request->raw_material_id);
            $rawMaterial->current_stock += $request->quantity;
            $rawMaterial->save();
            
            DB::commit(); // তিনটি কাজ সফল হলে ডেটা সেভ করা হবে
            return redirect()->route('superadmin.raw_material_receivings.index')->with('success', 'Stock In recorded and stock history updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack(); // কোনো একটি কাজ ব্যর্থ হলে সব বাতিল করা হবে
            return redirect()->back()->with('error', 'Stock In failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified receiving record (Invoice Details).
     */
    public function show(RawMaterialReceiving $rawMaterialReceiving)
    {
        // ইনভয়েস বিস্তারিত দেখানোর জন্য প্রয়োজনীয় ডেটা লোড করা
        $rawMaterialReceiving->load('rawMaterial', 'supplier', 'user'); 
        
        // ✅ এই ভেরিয়েবলটি এখন থেকে $receiving নামে ভিউতে পাস করা হবে (সহজ করার জন্য)
        $receiving = $rawMaterialReceiving; 
        
        return view('superadmin.raw_material_receivings.show', compact('receiving'));
    }
}