<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\RawMaterialStock;
use App\Models\ProductionIssue;     // Stock Out Header
use App\Models\ProductionIssueItem; // Stock Out Items
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RawMaterialStockOutController extends Controller
{
    /**
     * 🔹 Stock Out List
     */
    public function index()
    {
        $stockOuts = ProductionIssue::with('user')->latest()->paginate(10);
        return view('superadmin.raw_material_stock_out.index', compact('stockOuts'));
    }

    /**
     * 🔹 Create Form
     */
    public function create()
    {
        // শুধু যেসব কাঁচামালের স্টক আছে সেগুলো dropdown-এ দেখাবে
        $rawMaterials = RawMaterial::whereHas('stocks', function ($q) {
            $q->where('stock_quantity', '>', 0);
        })->orderBy('name')->get(['id', 'name', 'unit_of_measure']);

        return view('superadmin.raw_material_stock_out.create', compact('rawMaterials'));
    }

    /**
     * 🔹 AJAX: নির্দিষ্ট Raw Material এর জন্য স্টক ব্যাচ লোড করা
     * Route → superadmin/api/raw-material-stock/batches/{rawMaterialId}
     */
    public function getStockBatches(int $rawMaterialId)
    {
        // স্টকে যেগুলোর quantity > 0 শুধু সেগুলোই পাঠানো হচ্ছে
        $batches = RawMaterialStock::where('raw_material_id', $rawMaterialId)
            ->where('stock_quantity', '>', 0)
            ->get(['id', 'batch_number', 'stock_quantity', 'average_purchase_price'])
            ->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'batch_number' => $stock->batch_number,
                    'stock_quantity' => (float)$stock->stock_quantity,
                    'average_purchase_price' => (float)$stock->average_purchase_price,
                ];
            });

        return response()->json($batches);
    }

    /**
     * 🔹 Store (Save Stock Out)
     */
    public function store(Request $request)
    {
        $request->validate([
            'slip_number' => [
                'required', 'string', 'max:255',
                Rule::unique('production_issues', 'issue_number')
            ],
            'issue_date' => 'required|date',
            'factory_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',

            // Items validation
            'items' => 'required|array|min:1',
            'items.*.raw_material_id' => 'required|exists:raw_materials,id',
            'items.*.raw_material_stock_id' => 'required|exists:raw_material_stocks,id',
            'items.*.batch_number' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.unit_price' => 'required|numeric|min:0',
        ], [
            'slip_number.unique' => 'এই ইস্যু স্লিপ নম্বরটি ইতিমধ্যেই ব্যবহার করা হয়েছে।',
            'items.min' => 'দয়া করে অন্তত একটি কাঁচামাল যোগ করুন।',
        ]);

        DB::beginTransaction();
        try {
            // 1️⃣ Production Issue তৈরি
            $productionIssue = ProductionIssue::create([
                'issue_number' => $request->slip_number,
                'issue_date' => $request->issue_date,
                'factory_name' => $request->factory_name,
                'user_id' => Auth::id(),
                'notes' => $request->notes,
            ]);

            $totalQuantity = 0;
            $totalCost = 0;

            // 2️⃣ প্রতিটি আইটেমের জন্য লুপ
            foreach ($request->items as $item) {
                $issuedQty = (float)$item['quantity'];
                $unitCost = (float)$item['unit_price'];
                $lineTotal = $issuedQty * $unitCost;

                // স্টক বের করা
                $stock = RawMaterialStock::find($item['raw_material_stock_id']);

                // পর্যাপ্ত স্টক আছে কি না যাচাই
                if (!$stock || $stock->stock_quantity < $issuedQty) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'স্টক পর্যাপ্ত নেই। দয়া করে স্টক রিপোর্ট চেক করুন।');
                }

                // স্টক থেকে quantity কমানো
                $stock->decrement('stock_quantity', $issuedQty);

                // Production Issue Item তৈরি
                ProductionIssueItem::create([
                    'production_issue_id' => $productionIssue->id,
                    'raw_material_id' => $item['raw_material_id'],
                    'raw_material_stock_id' => $item['raw_material_stock_id'],
                    'batch_number' => $item['batch_number'],
                    'quantity_issued' => $issuedQty,
                    'unit_cost' => $unitCost,
                    'total_cost' => $lineTotal,
                ]);

                $totalQuantity += $issuedQty;
                $totalCost += $lineTotal;
            }

            // 3️⃣ মোট যোগফল আপডেট করা
            $productionIssue->update([
                'total_quantity_issued' => $totalQuantity,
                'total_issue_cost' => round($totalCost, 2),
            ]);

            DB::commit();
            return redirect()->route('superadmin.raw-material-stock-out.index')
                             ->with('success', 'কাঁচামাল ইস্যু সফলভাবে সংরক্ষণ করা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * 🔹 Show a single issue slip
     */
    public function show(ProductionIssue $raw_material_stock_out)
    {
        $stockOut = $raw_material_stock_out->load(['user', 'items.rawMaterial']);
        return view('superadmin.raw_material_stock_out.show', compact('stockOut'));
    }

    /**
     * 🔹 Delete issue slip
     */
    public function destroy(ProductionIssue $raw_material_stock_out)
    {
        try {
            $raw_material_stock_out->delete();
            return redirect()->route('superadmin.raw-material-stock-out.index')
                             ->with('success', 'ইস্যু স্লিপটি ডিলিট করা হয়েছে।');
        } catch (\Exception $e) {
            return back()->with('error', 'ইস্যু স্লিপটি ডিলিট করা সম্ভব হয়নি।');
        }
    }
}
