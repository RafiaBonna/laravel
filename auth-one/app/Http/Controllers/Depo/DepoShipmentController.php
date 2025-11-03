<?php

namespace App\Http\Controllers\Depo;

use App\Http\Controllers\Controller;
use App\Models\Shipment; 
use App\Models\DepoRawMaterialStock; // Depo-এর স্টক মডেল
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepoShipmentController extends Controller
{
    /**
     * Display a listing of PENDING shipments for the logged-in Depo.
     */
    public function index()
    {
        // লগইন করা ইউজারের Depo ID
        $depoId = Auth::user()->depo_id; 
        
        // Depo-এর জন্য পাঠানো Raw Material Shipments-এর তালিকা
        $shipments = Shipment::where('depo_id', $depoId)
            ->where('shipment_type', 'RAW_MATERIAL')
            ->with(['rawMaterial', 'user'])
            ->latest()
            ->get();

        return view('depo.shipments.index', compact('shipments'));
    }

    /**
     * Handle the action to receive a specific shipment.
     */
    public function receive(Shipment $shipment)
    {
        // ১. অথোরাইজেশন চেক: এই শিপমেন্টটি লগইন করা ডিপো-এর জন্যই কিনা?
        if ($shipment->depo_id !== Auth::user()->depo_id) {
            return redirect()->route('depo.shipments.index')->with('error', 'Unauthorized action. This shipment is not for your Depo.');
        }

        // ২. স্ট্যাটাস চেক: শিপমেন্টটি PENDING আছে কিনা?
        if ($shipment->status !== 'PENDING') {
            return redirect()->route('depo.shipments.index')->with('error', 'Shipment is already received or cancelled.');
        }

        // ৩. Database Transaction শুরু
        DB::beginTransaction();
        try {
            // ৪. Shipment স্ট্যাটাস আপডেট করা
            $shipment->status = 'RECEIVED';
            $shipment->received_date = now();
            $shipment->receiver_user_id = Auth::id(); // যিনি রিসিভ করছেন
            $shipment->save();

            // ৫. ✅ Depo-এর Raw Material Stock আপডেট করা (স্টক ইন)
            $depoStock = DepoRawMaterialStock::firstOrNew([
                'raw_material_id' => $shipment->raw_material_id,
                'depo_id' => $shipment->depo_id,
            ]);
            
            // স্টক যোগ করা
            $depoStock->current_stock += $shipment->quantity;
            $depoStock->save();


            DB::commit();
            return redirect()->route('depo.shipments.index')->with('success', 'Shipment successfully received and stock added to Depo Inventory.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Logging the error is helpful for debugging
            \Log::error("Depo Receive Failed: " . $e->getMessage()); 
            return redirect()->back()->with('error', 'Receiving shipment failed. Please contact support.');
        }
    }
}
