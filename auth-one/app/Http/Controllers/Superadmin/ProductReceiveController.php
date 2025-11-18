<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\ProductReceive;
use App\Models\ProductReceiveItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReceiveController extends Controller
{
    public function index()
    {
        $receives = ProductReceive::latest()->paginate(20);
        return view('superadmin.product_receives.index', compact('receives'));
    }

    public function create()
    {
        $products = Product::all();
        return view('superadmin.product_receives.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receive_date' => 'required|date',
            'product_id.*' => 'required',
            'received_quantity.*' => 'required|numeric|min:0.1',
        ]);

        // Auto Receive No (PR-2025-0001)
        $receive_no = 'PR-' . date('Y') . '-' . str_pad(ProductReceive::count() + 1, 4, '0', STR_PAD_LEFT);

        $receive = ProductReceive::create([
            'receive_no' => $receive_no,
            'receive_date' => $request->receive_date,
            'note' => $request->note,
            'total_received_qty' => array_sum($request->received_quantity),
            'received_by_user_id' => auth()->id(),
            'total_cost' => 0,
        ]);

        $total_cost = 0;

        foreach ($request->product_id as $index => $product_id) {

            $qty = $request->received_quantity[$index];
            $rate = $request->cost_rate[$index] ?? 0;
            $item_cost = $qty * $rate;

            ProductReceiveItem::create([
                'product_receive_id' => $receive->id,
                'product_id' => $product_id,
                'batch_no' => $request->batch_no[$index] ?? null,
                'production_date' => $request->production_date[$index] ?? null,
                'expiry_date' => $request->expiry_date[$index] ?? null,
                'received_quantity' => $qty,
                'cost_rate' => $rate,
                'total_item_cost' => $item_cost,
            ]);

            $total_cost += $item_cost;
        }

        // Update total cost
        $receive->update(['total_cost' => $total_cost]);

        return redirect()->route('superadmin.product-receives.index')
            ->with('success', 'Product Receive created successfully!');
    }
    public function show($id)
{
    $receive = ProductReceive::with(['items.product', 'user'])->findOrFail($id);
    return view('superadmin.product_receives.show', compact('receive'));
}

}

