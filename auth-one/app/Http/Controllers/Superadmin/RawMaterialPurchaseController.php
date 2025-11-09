<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\PurchaseInvoice;
use App\Models\RawMaterialPurchaseItem;
use App\Models\RawMaterialStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RawMaterialPurchaseController extends Controller
{
    // 1. Purchase Invoice List দেখানোর জন্য (Index)
    public function index()
    {
        $invoices = PurchaseInvoice::with(['supplier', 'user'])->latest()->paginate(10);
        // ভিউ ফাইল: resources/views/superadmin/raw_material_purchases/index.blade.php
        return view('superadmin.raw_material_purchases.index', compact('invoices'));
    }

    // 2. নতুন Purchase তৈরির ফর্ম দেখানোর জন্য (Create Form)
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get(['id', 'name']);
        $rawMaterials = RawMaterial::orderBy('name')->get(['id', 'name', 'unit_of_measure']);

        // ভিউ ফাইল: resources/views/superadmin/raw_material_purchases/create.blade.php
        return view('superadmin.raw_material_purchases.create', compact('suppliers', 'rawMaterials'));
    }

    // 3. Purchase ডাটাবেসে সংরক্ষণ এবং স্টক আপডেট করার জন্য (Store)
    public function store(Request $request)
    {
        // 3.1. Validation
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:purchase_invoices,invoice_number',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'discount_amount' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'calculated_total' => 'required|numeric|same:grand_total', // Security check from JS
            'items' => 'required|array|min:1',
            'items.*.raw_material_id' => 'required|exists:raw_materials,id',
            'items.*.batch_number' => 'required|string|max:50',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
        ], [
            'invoice_number.unique' => 'এই ইনভয়েস নম্বরটি ইতোমধ্যে সিস্টেমে আছে।',
            'calculated_total.same' => 'মোট টাকার পরিমাণ গণনায় সমস্যা আছে। ফর্ম রিফ্রেশ করে আবার চেষ্টা করুন।',
            'items.required' => 'কমপক্ষে একটি কাঁচামাল যোগ করুন।',
            'items.*.quantity.min' => 'পরিমাণ অবশ্যই ০ এর বেশি হতে হবে।',
        ]);

        $subTotal = collect($request->items)->sum('total_price');

        // ট্রানজেকশন শুরু: কোনো ভুল হলে সবকিছু বাতিল হবে
        DB::beginTransaction();
        try {
            // 3.2. Create Purchase Invoice (Master)
            $invoice = PurchaseInvoice::create([
                'invoice_number' => $request->invoice_number,
                'supplier_id' => $request->supplier_id,
                'invoice_date' => $request->invoice_date,
                'sub_total' => $subTotal,
                'discount_amount' => $request->discount_amount ?? 0,
                'grand_total' => $request->grand_total,
                'notes' => $request->notes,
                'user_id' => Auth::id(), // বর্তমান লগইন করা ইউজার আইডি
            ]);

            // 3.3. Process Purchase Items and Stock Update
            foreach ($request->items as $itemData) {
                // a. Create Purchase Item (Detail)
                $item = RawMaterialPurchaseItem::create([
                    'purchase_invoice_id' => $invoice->id,
                    'raw_material_id' => $itemData['raw_material_id'],
                    'batch_number' => $itemData['batch_number'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['total_price'],
                ]);
                
                // b. Update Raw Material Stock (স্টক লজিক)
                $this->updateStock($item);
            }

            DB::commit(); // ট্রানজেকশন সফল: ডেটাবেসে সংরক্ষণ
            return redirect()->route('superadmin.raw-material-purchases.index')
                             ->with('success', 'কাঁচামাল সফলভাবে ক্রয় এবং স্টক ইন করা হয়েছে। ইনভয়েস নম্বর: ' . $invoice->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack(); // কোনো সমস্যা হলে সবকিছু বাতিল
            return back()->with('error', 'ক্রয় প্রক্রিয়া সফল হয়নি। Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Helper function to update stock using Moving Average Cost (MAC) method.
     */
    private function updateStock(RawMaterialPurchaseItem $item)
    {
        $existingStock = RawMaterialStock::where('raw_material_id', $item->raw_material_id)
                                         ->where('batch_number', $item->batch_number)
                                         ->first();
        
        $newQuantity = (float)$item->quantity;
        $newPrice = (float)$item->unit_price;
        
        if ($existingStock) {
            $oldQuantity = (float)$existingStock->stock_quantity;
            $oldAvgPrice = (float)$existingStock->average_purchase_price;

            // Moving Average Cost (MAC) Calculation: (Old Total Value + New Total Value) / (Old Total Qty + New Total Qty)
            $newAvgPrice = (($oldQuantity * $oldAvgPrice) + ($newQuantity * $newPrice)) / ($oldQuantity + $newQuantity);

            // Update existing stock
            $existingStock->increment('stock_quantity', $newQuantity); // Increment quantity
            $existingStock->update([
                'average_purchase_price' => round($newAvgPrice, 4), // কস্ট ৪ দশমিক পর্যন্ত রাখলাম
                'last_in_date' => now()->toDateString(),
            ]);
            
        } else {
            // New stock entry
            RawMaterialStock::create([
                'raw_material_id' => $item->raw_material_id,
                'batch_number' => $item->batch_number,
                'stock_quantity' => $newQuantity,
                'average_purchase_price' => $newPrice,
                'last_in_date' => now()->toDateString(),
            ]);
        }
    }
}