<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule; // <-- Import Rule for unique validation

class DepotController extends Controller
{
    // Show all depots
    public function index()
    {
        $depots = Depot::all();
        return view('pages.depot.index', compact('depots'));
    }

    // Show create form
    public function create()
    {
        return view('pages.depot.create');
    }

    // Store new depot
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:depots,name',
            'address' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
        ]);

        Depot::create($request->all());

        return Redirect::route('depot.index')->with('success', 'Depot added successfully!');
    }
    
    // Show edit form
    public function edit($id)
    {
        $depot = Depot::findOrFail($id);
        return view('pages.depot.edit', compact('depot'));
    }
    
    // Update depot
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Ignore the current depot's ID for unique check
                Rule::unique('depots', 'name')->ignore($id) 
            ],
            'address' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
        ]);

        $depot = Depot::findOrFail($id);
        
        // Update only the validated fields
        $depot->update($request->only('name', 'address', 'manager_name'));

        return Redirect::route('depot.index')->with('success', 'Depot updated successfully!');
    }

    // Delete depot
    public function destroy($id)
    {
        $depot = Depot::findOrFail($id);
        $depot->delete();
        return Redirect::route('depot.index')->with('success', 'Depot deleted successfully!');
    }
}