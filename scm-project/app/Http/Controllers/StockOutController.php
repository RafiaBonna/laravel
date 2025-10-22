<?php

// app/Http/Controllers/StockOutController.php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\RawMaterial; 
use App\Models\Depot;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockOutController extends Controller
{
    /**
     * Stock Out List View (stockout.index)
     */
    public function index()
    {
        // Fetch all Stock Out transactions with related master data
        $stockOuts = StockOut::with('rawMaterial', 'depot')->latest()->get();
        // View Path: pages.stock_out.index 
        return view('pages.stock_out.index', compact('stockOuts')); 
    }

    /**
     * Issue Material Form (stockout.create)
     */
    public function create()
    {
        // Form এর জন্য Raw Material এবং Depot মাস্টার ডেটা লোড করা
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit', 'current_stock', 'alert_stock']);
        // ধরে নিলাম Depot Model/Table আছে
        $depots = Depot::all(['id', 'name']); 
        
        // View Path: pages.stock_out.create 
        return view('pages.stock_out.create', compact('rawMaterials', 'depots'));
    }

    /**
     * Store Logic (Issue Material Submission & Stock Update) (stockout.store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'depot_id' => 'nullable|exists:depots,id', // Depot-এর রুলস
            'issued_quantity' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $material = RawMaterial::findOrFail($request->raw_material_id);
            
            // ১. স্টক চেক: স্টক আউট করার আগে পর্যাপ্ত স্টক আছে কি না
            if ($material->current_stock < $request->issued_quantity) {
                DB::rollBack();
                return Redirect::back()->withInput()->with('error', 'Insufficient stock! Current stock: ' . $material->current_stock . ' ' . $material->unit);
            }

            // ২. stock_outs (transaction) table record
            StockOut::create([
                'raw_material_id' => $request->raw_material_id, 
                'depot_id' => $request->depot_id,
                'issued_quantity' => $request->issued_quantity,
                'unit' => $material->unit, // take unit from Master 
                // cost_price আপাতত বাদ দিলাম, প্রয়োজন হলে যোগ করে নিতে পারেন 
            ]);

            // ৩. raw_materials (master) table update: current_stock কমানো হলো
            $material->current_stock -= $request->issued_quantity;
            $material->save();

            DB::commit();

            return Redirect::route('stockout.index')->with('success', 'Material issued and stock updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e); // Debug করার জন্য
            return Redirect::back()->withInput()->with('error', 'Failed to issue material. Please try again. Error: ' . $e->getMessage());
        }
    }
    
    /**
     * View Invoice (stockout.invoice)
     */
    public function invoice($id)
    {
        $stock = StockOut::with('rawMaterial', 'depot')->findOrFail($id);
        // View Path: pages.stock_out.invoice 
        return view('pages.stock_out.invoice', compact('stock'));
    }
}