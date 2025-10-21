<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\RawMaterial;
use App\Models\User; // Recipient/Issuer এর জন্য User মডেল
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon; // Date Handling এর জন্য

class StockOutController extends Controller
{
    /**
     * Stock Out List View (Route: stockout.index)
     */
    public function index()
    {
        // Fetch all Stock Out transactions with related raw material and issuer data
        $stockOuts = StockOut::with('rawMaterial', 'issuer')->latest()->get();
        return view('pages.stock_out.index', compact('stockOuts')); 
    }

    /**
     * Product Issue Form (Route: stockout.create)
     */
    public function create()
    {
        // Form এর জন্য Raw Material মাস্টার ডেটা এবং Recipient/User লোড করা
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit', 'current_stock']);
        $users = User::all(['id', 'name']);
        
        return view('pages.stock_out.create', compact('rawMaterials', 'users'));
    }

    /**
     * Store Logic (Product Issue Submission & Stock Update) (Route: stockout.store)
     */
    public function store(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'issued_by_user_id' => 'required|exists:users,id',
            'issued_quantity' => 'required|numeric|min:0.01',
            'purpose' => 'nullable|string|max:255',
        ]);
        
        $material = RawMaterial::findOrFail($request->raw_material_id);

        // ২. স্টক চেক (গুরুত্বপূর্ণ)
        if ($request->issued_quantity > $material->current_stock) {
            return Redirect::back()->withInput()->with('error', 'The requested quantity is more than the current stock (Current: ' . $material->current_stock . ' ' . $material->unit . ').');
        }

        DB::beginTransaction();

        try {
            // ৩. stock_outs (transaction) table record
            StockOut::create([
                'raw_material_id' => $request->raw_material_id, 
                'issued_by_user_id' => $request->issued_by_user_id,
                'issued_quantity' => $request->issued_quantity,
                'unit' => $material->unit, 
                'purpose' => $request->purpose,
                'issue_date' => Carbon::today(),
            ]);

            // ৪. raw_materials (master) table update (Stock Decrease)
            $material->current_stock -= $request->issued_quantity;
            $material->save();

            DB::commit();

            return Redirect::route('stockout.index')->with('success', 'Material issued and stock updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error($e); // If you have logging enabled
            return Redirect::back()->withInput()->with('error', 'Failed to issue material. Please try again.');
        }
    }

    /**
     * View Stock Out Invoice
     * Route Name: stockout.invoice
     */
    public function invoice($id)
    {
        // StockOut record, Material এবং Issuer ডেটা সহ লোড করা
        $stock = StockOut::with('rawMaterial', 'issuer')->findOrFail($id);
        
        // View Path: resources/views/pages/stock_out/invoice.blade.php
        return view('pages.stock_out.invoice', compact('stock'));
    }
}