<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\Depo;
use App\Models\Product;
use App\Models\ProductStock;
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
        
        // Active Products লোড করা হচ্ছে (যেগুলোর is_active = 1)
        $products = Product::where('is_active', 1)->orderBy('name')->get(); 
        
        return view('superadmin.sales.create', compact('depos', 'products'));
    }

    /**
     * Store a newly created resource in storage. (superadmin.sales.store)
     */
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'depo_id' => ['required', 'exists:depos,id'],
            'invoice_date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.product_stock_id' => ['required', 'exists:product_stocks,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();

        try {
            // ১. Sales Invoice তৈরি করা
            $invoice = SalesInvoice::create([
                'invoice_no' => 'SI-' . time(), 
                'invoice_date' => $request->invoice_date,
                'total_amount' => $request->total_amount,
                'user_id' => Auth::id(), 
                'depo_id' => $request->depo_id,
                'status' => 'Pending', 
            ]);

            // ২. Invoice Items যোগ করা এবং Product Stock আপডেট করা
            foreach ($request->items as $itemData) {
                // Stock থেকে Quantity কমানো
                $stock = ProductStock::find($itemData['product_stock_id']);
                
                // এখানে একটি জরুরি চেক: স্টক থেকে যেন বেশি বিক্রি না হয়
                if (!$stock || $stock->available_quantity < $itemData['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', 'Insufficient stock for product batch ID ' . $itemData['product_stock_id']);
                }

                // স্টক আপডেট: পরিমাণ কমানো
                $stock->available_quantity -= $itemData['quantity'];
                $stock->save();

                // Invoice Item তৈরি করা
                $invoice->items()->create([
                    'product_id' => $itemData['product_id'],
                    'product_stock_id' => $itemData['product_stock_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'sub_total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }

            DB::commit();

            return redirect()->route('superadmin.sales.index')->with('success', 'Sales Invoice successfully created and sent for Depo approval.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create Sales Invoice. Please try again. Error: ' . $e->getMessage());
        }
    }


    /**
     * API: Load Stock Batches for a specific Product ID.
     * FIX: Ensure 'available_quantity' is selected to match JS expectation.
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