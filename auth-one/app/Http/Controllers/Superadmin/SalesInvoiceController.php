<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\Depo;
use App\Models\Product;
use App\Models\ProductStock; // ✅ নিশ্চিত করুন এই মডেলটি আছে
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource (Sales Invoices). (superadmin.sales.index)
     */
    public function index()
    {
        $invoices = SalesInvoice::with('depo', 'creator')
            ->orderBy('invoice_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);
        
        return view('superadmin.sales.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource (Sales Invoice). (superadmin.sales.create)
     */
    public function create()
    {
        // Depots লোড করা হচ্ছে
        $depos = Depo::orderBy('name')->get(); 
        
        // Active Products লোড করা হচ্ছে
        $products = Product::where('is_active', 1)->orderBy('name')->get(); 
        
        return view('superadmin.sales.create', compact('depos', 'products'));
    }

    /**
     * Store a newly created resource in storage. (superadmin.sales.store)
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'depo_id' => 'required|exists:depos,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            // 'product_stock_id' validation will be done via custom logic in a real-world scenario, but required for now.
            'items.*.product_stock_id' => 'required|exists:product_stocks,id', 
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // 2. Invoice No. Generate (আপনার লজিক অনুযায়ী এটি যোগ করবেন)
        $invoiceNo = 'SI-' . time(); 
        
        DB::beginTransaction();

        try {
            // 3. Sales Invoice তৈরি করা
            $invoice = SalesInvoice::create([
                'invoice_no' => $invoiceNo,
                'invoice_date' => $request->invoice_date,
                'total_amount' => 0, // পরে আপডেট করা হবে
                'user_id' => Auth::id(),
                'depo_id' => $request->depo_id,
                'status' => 'Pending', // ✅ ইনভয়েস Pending স্ট্যাটাসে তৈরি হচ্ছে
            ]);

            $grandTotal = 0;
            
            // 4. Items সংরক্ষণ করা
            foreach ($request->items as $itemData) {
                // স্টক এবং প্রাইস ফ্রন্ট-এ চেক করা হয়েছে। এখানে শুধু সেভ করা হচ্ছে।
                $subTotal = $itemData['quantity'] * $itemData['unit_price'];
                $grandTotal += $subTotal;
                
                $invoice->items()->create([
                    'product_id' => $itemData['product_id'],
                    'product_stock_id' => $itemData['product_stock_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'sub_total' => $subTotal,
                ]);
            }

            // 5. Grand Total আপডেট করা
            $invoice->update(['total_amount' => round($grandTotal, 2)]);
            
            DB::commit();

            return redirect()->route('superadmin.sales.index')->with('success', 'Sales Invoice successfully created and sent for Depo approval.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create Sales Invoice. Please try again. Error: ' . $e->getMessage());
        }
    }


    /**
     * API: Load Stock Batches for a specific Product ID.
     */
    public function getProductBatches($productId)
    {
        // Load active stock batches where quantity > 0
        $batches = ProductStock::where('product_id', $productId)
            ->where('available_quantity', '>', 0)
            ->get(['id', 'batch_no', 'available_quantity', 'unit_price']); 

        return response()->json($batches);
    }
    
    // Placeholder methods for resource routes
    public function show(SalesInvoice $salesInvoice) { /* ... */ }
    public function edit(SalesInvoice $salesInvoice) { /* ... */ }
    public function update(Request $request, SalesInvoice $salesInvoice) { /* ... */ }
    public function destroy(SalesInvoice $salesInvoice) { /* ... */ }
}