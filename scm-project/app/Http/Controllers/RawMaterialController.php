<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule; // ✅ Added to fix the unique validation error

class RawMaterialController extends Controller
{
    // Show all raw materials
    public function index()
    {
        $materials = RawMaterial::all();
        return view('pages.raw_material.index', compact('materials'));
    }

    // Show create form
    public function create()
    {
        return view('pages.raw_material.create');
    }

    // Store new raw material
    public function store(Request $request)
    {
        $request->validate([
            // ✅ FIX: Rule::unique ব্যবহার করা হয়েছে যেন Raw Material-এর নামে স্পেস থাকলেও ঠিকভাবে কাজ করে
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('raw_materials', 'name')
            ],
            'unit' => 'required|string|max:50',
            'alert_stock' => 'required|numeric|min:0',
        ]);

        RawMaterial::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'alert_stock' => $request->alert_stock,
            'current_stock' => 0,
        ]);

        return Redirect::route('raw_material.index')->with('success', 'Raw Material added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $material = RawMaterial::findOrFail($id);
        return view('pages.raw_material.edit', compact('material'));
    }

    // Update raw material
    public function update(Request $request, $id)
    {
        $request->validate([
            // ✅ Update: edit-এর জন্যও Rule::unique ব্যবহার করা হয়েছে (ID ignore করে)
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('raw_materials', 'name')->ignore($id)
            ],
            'unit' => 'required|string|max:50',
            'alert_stock' => 'required|numeric|min:0',
        ]);

        $material = RawMaterial::findOrFail($id);
        
        // শুধু validated field গুলো update করা হলো
        $material->update($request->only('name', 'unit', 'alert_stock'));

        return Redirect::route('raw_material.index')->with('success', 'Raw Material updated successfully!');
    }

    // Delete raw material
    public function destroy($id)
    {
        $material = RawMaterial::findOrFail($id);
        $material->delete();
        return Redirect::route('raw_material.index')->with('success', 'Raw Material deleted successfully!');
    }
}