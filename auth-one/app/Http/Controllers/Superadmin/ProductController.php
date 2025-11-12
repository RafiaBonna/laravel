<?php
// app/Http/Controllers/Superadmin/ProductController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Product List / Entry Index
     */
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('superadmin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('superadmin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'unit' => 'required|string|max:50',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'sku' => $request->sku,
            'description' => $request->description,
            'created_by' => Auth::id(), // যিনি তৈরি করলেন
            'current_stock' => 0, // নতুন প্রোডাক্টের স্টক প্রথমে ০ থাকবে
        ]);

        return redirect()->route('superadmin.products.index')
                         ->with('success', 'New Product added successfully!');
    }

    // show(), edit(), update(), destroy() ফাংশনগুলো প্রয়োজন অনুযায়ী পরে যোগ করা যাবে...
    
    public function show(Product $product) { /* ... */ }
    public function edit(Product $product) { /* ... */ }
    public function update(Request $request, Product $product) { /* ... */ }
    public function destroy(Product $product) { /* ... */ }
}