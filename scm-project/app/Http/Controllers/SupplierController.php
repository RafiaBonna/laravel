<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    // ✅ Show all suppliers
    public function index()
    {
        $suppliers = Supplier::all();
        return view('pages.supplier.view', compact('suppliers'));
    }

    // ✅ Create form
    public function create()
    {
        return view('pages.supplier.add-supplier');
    }

    // ✅ Store supplier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Supplier::create($request->all());

        return Redirect::route('supplier.index');
    }

    // ✅ Edit form
    public function edit($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        return view('pages.supplier.edit', compact('supplier'));
    }

    // ✅ Update supplier
    public function updateStore(Request $request)
    {
        $supplier = Supplier::findOrFail($request->supplier_id);
        $supplier->update($request->all());

        return Redirect::route('supplier.index');
    }

    // ✅ Delete supplier
    public function destroy(Request $request)
    {
        $supplier = Supplier::findOrFail($request->supplier_id);
        $supplier->delete();

        return Redirect::route('supplier.index');
    }
}
