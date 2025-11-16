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
        $products = Product::where('is_active', true)->pluck('name', 'id'); 
        $nextReceiveNo = 'PR-' . date('Ym') . '-' . str_pad(ProductReceive::count() + 1, 4, '0', STR_PAD_LEFT);
        return view('superadmin.product_receives.create', compact('products', 'nextReceiveNo'));
    }

    /**
     * Store a newly created product receive.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receive_no' => 'required|string|max:100|unique:product_receives,receive_no',
            'receive_date' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.batch_no' => 'required|string|max:100',
            'items.*.received_quantity' => 'required|numeric|min:0.01', 
            'items.*.cost_rate' => 'required|numeric|min:0',
            'items.*.production_date' => 'nullable|date',
            'items.*.expiry_date' => 'nullable|date|after:production_date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $totalReceivedQty = array_sum(array_column($request->items, 'received_quantity'));

            $receive = ProductReceive::create([
                'receive_no' => $request->receive_no,
                'receive_date' => $request->receive_date,
                'note' => $request->note,
                'total_received_qty' => $totalReceivedQty,
                'received_by_user_id' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                ProductReceiveItem::create([
                    'product_receive_id' => $receive->id,
                    'product_id' => $item['product_id'],
                    'batch_no' => $item['batch_no'],
                    'production_date' => $item['production_date'] ?? null,
                    'expiry_date' => $item['expiry_date'] ?? null,
                    'received_quantity' => (float)$item['received_quantity'],
                    'cost_rate' => (float)$item['cost_rate'] ?? 0,
                ]);

                $stock = ProductStock::firstOrNew([
                    'product_id' => $item['product_id'],
                    'batch_no' => $item['batch_no'],
                ]);

                if (!$stock->exists) {
                    $stock->expiry_date = $item['expiry_date'] ?? null;
                    $stock->available_quantity = 0;
                }

                $stock->available_quantity += (float)$item['received_quantity'];
                $stock->save();

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('current_stock', (float)$item['received_quantity']);
                }
            }

            DB::commit();
            return redirect()->route('superadmin.product-receives.index')
                             ->with('success', 'Product Receive completed successfully! Stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to complete Product Receive. Transaction aborted.')->withInput();
        }
    }

    /**
     * AJAX/API কলের জন্য নতুন আইটেম রো-এর HTML কন্টেন্ট
     */
    public function getItemRow(Request $request)
    {
        $i = $request->input('i'); 
        $products = Product::where('is_active', true)->pluck('name', 'id');
        return view('superadmin.product_receives.partials.receive_item_row', compact('i', 'products'))->render();
    }

    /**
     * Display the specified product receive invoice.
     */
    public function show(ProductReceive $productReceive)
    {
        $receive = $productReceive->load(['receiver', 'items.product']);
        return view('superadmin.product_receives.show', compact('receive'));
    }

    // পরবর্তীতে edit(), update(), destroy() যোগ করা যাবে
}
