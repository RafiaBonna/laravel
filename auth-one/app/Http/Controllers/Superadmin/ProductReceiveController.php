<?php

// app/Http/Controllers/Superadmin/ProductReceiveController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductReceiveController extends Controller
{
    /**
     * Product Receive List
     */
    public function index()
    {
        $receives = ProductReceive::latest()->with('receiver')->paginate(20);
        return view('superadmin.product_receives.index', compact('receives'));
    }

    /**
     * Show the form for creating a new product receive.
     */
    public function create()
    {
        // রিসিভ ফর্মে প্রোডাক্ট সিলেক্ট করার জন্য
        $products = Product::where('is_active', true)->pluck('name', 'id'); 
        $nextReceiveNo = 'PR-' . date('Ym') . '-' . str_pad(ProductReceive::count() + 1, 4, '0', STR_PAD_LEFT);
        
        return view('superadmin.product_receives.create', compact('products', 'nextReceiveNo'));
    }

    /**
     * Store a newly created product receive.
     * (Core logic for multi-product and stock update)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receive_date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.batch_no' => 'required|string|max:100',
            'items.*.received_quantity' => 'required|numeric|min:0.01',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // DB Transaction for Stock Safety
        DB::beginTransaction();
        try {
            $totalQty = collect($request->items)->sum('received_quantity');

            // 1. Save Product Receive Header
            $receive = ProductReceive::create([
                'receive_no' => $request->receive_no ?? ('PR-' . now()->format('YmdHis')), // ফলব্যাক নম্বর
                'receive_date' => $request->receive_date,
                'note' => $request->note,
                'total_received_qty' => $totalQty,
                'received_by_user_id' => Auth::id(),
            ]);

            // 2. Process Items and Update Stock
            foreach ($request->items as $item) {
                // Save Product Receive Item
                ProductReceiveItem::create([
                    'product_receive_id' => $receive->id,
                    'product_id' => $item['product_id'],
                    'batch_no' => $item['batch_no'],
                    'production_date' => $item['production_date'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'received_quantity' => $item['received_quantity'],
                    'cost_rate' => $item['cost_rate'] ?? 0,
                ]);

                // Update Product Stock (Add/Update Batch)
                $stock = ProductStock::firstOrNew([
                    'product_id' => $item['product_id'],
                    'batch_no' => $item['batch_no'],
                ]);
                
                // Expiry date update only if it's new
                if (!$stock->exists) {
                    $stock->expiry_date = $item['expiry_date'] ?? null;
                    $stock->available_quantity = 0; // First time init
                }
                
                $stock->available_quantity += $item['received_quantity'];
                $stock->save();

                // Update Product Master Stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('current_stock', $item['received_quantity']);
                }
            }

            DB::commit();
            return redirect()->route('superadmin.product-receives.index')
                             ->with('success', 'Product Receive completed successfully! Stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error $e->getMessage() for debugging
            return back()->with('error', 'Failed to complete Product Receive. Transaction aborted.')->withInput();
        }
    }
    
    // show(), edit(), update(), destroy() ফাংশনগুলো পরে যোগ করা যাবে...
}
