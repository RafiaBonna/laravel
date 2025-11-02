<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\RawMaterial;
use App\Models\StockMovement;
use App\Models\Shipment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RawMaterialShipmentController extends Controller
{
    /**
     * Display a listing of the shipments (Transfers).
     */
    public function index()
    {
        // Shipped Raw Materials-এর তালিকা
        $shipments = Shipment::where('shipment_type', 'RAW_MATERIAL')
            ->with(['rawMaterial', 'depo', 'user', 'receiver'])
            ->latest()
            ->get();

        return view('superadmin.raw_material_shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new shipment (Stock Out for Transfer).
     */
    public function create()
    {
        $rawMaterials = RawMaterial::all(['id', 'name', 'unit', 'current_stock']);
        $depos = Depo::all(['id', 'name', 'location']); 
        
        return view('superadmin.raw_material_shipments.create', compact('rawMaterials', 'depos'));
    }

    /**
     * Store a newly created shipment AND update stock. (Stock Out)
     */
    public function store(Request $request)
    {
        $request->validate([
            'depo_id' => 'required|exists:depos,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|numeric|min:0.01',
            'shipment_date' => 'required|date|before_or_equal:today',
            'driver_name' => 'nullable|string|max:255',
        ]);

        // ১. Raw Material-এর স্টক চেক করা
        $rawMaterial = RawMaterial::findOrFail($request->raw_material_id);
        if ($request->quantity > $rawMaterial->current_stock) {
            return redirect()->back()->with('error', 'Insufficient stock. Available: ' . number_format($rawMaterial->current_stock, 2) . ' ' . $rawMaterial->unit)->withInput();
        }

        // ২. Database Transaction শুরু
        DB::beginTransaction();
        try {
            // ৩. Shipment Record তৈরি (স্ট্যাটাস PENDING)
            $shipment = Shipment::create([
                'raw_material_id' => $request->raw_material_id,
                'depo_id' => $request->depo_id,
                'quantity' => $request->quantity,
                'shipment_date' => $request->shipment_date,
                'driver_name' => $request->driver_name,
                'shipment_type' => 'RAW_MATERIAL', 
                'status' => 'PENDING', 
                'user_id' => Auth::id(), 
            ]);

            // ৪. Stock Movement Record তৈরি (Stock Out History)
            StockMovement::create([
                'raw_material_id' => $request->raw_material_id,
                'type' => 'OUT', 
                'quantity' => $request->quantity,
                'reference_type' => Shipment::class, 
                'reference_id' => $shipment->id,
                'user_id' => Auth::id(),
            ]);

            // ৫. Raw Material এর বর্তমান স্টক আপডেট করা (স্টক কমানো)
            $rawMaterial->current_stock -= $request->quantity;
            $rawMaterial->save();
            
            DB::commit();
            return redirect()->route('superadmin.raw_material_shipments.index')->with('success', 'Shipment recorded and stock successfully transferred out. Status: PENDING');
            
        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()->with('error', 'Shipment failed: ' . $e->getMessage())->withInput();
        }
    }
}
