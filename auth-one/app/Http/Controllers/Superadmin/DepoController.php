<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 

class DepoController extends Controller
{
    /**
     * Display a listing of the resource (Depo List).
     */
    public function index()
    {
        $depos = Depo::all(); 
        return view('superadmin.depos.index', compact('depos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.depos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('depos', 'name')], 
            'location' => ['required', 'string', 'max:255'],
        ]);

        Depo::create([
            'user_id' => Auth::id(), // FIX: Adds the currently logged-in Superadmin's ID
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('superadmin.depos.index')->with('success', 'Depo created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depo $depo) 
    {
        $depo->delete();
        return redirect()->route('superadmin.depos.index')->with('success', 'Depo deleted successfully!');
    }
    
    // Placeholder methods for completeness
    public function show(Depo $depo) {}
    public function edit(Depo $depo) {}
    public function update(Request $request, Depo $depo) {}
}
