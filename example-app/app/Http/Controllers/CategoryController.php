<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::all();
        return view('index', compact('cats'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'value' => 'required',
        ]);

        Category::create($request->only(['name', 'brand', 'value']));
        return Redirect::route('category.index')->with('success', '✅ Category added successfully!');
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        return view('edit', compact('cat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'value' => 'required',
        ]);

        $cat = Category::findOrFail($id);
        $cat->update($request->only(['name', 'brand', 'value']));
        return Redirect::route('category.index')->with('success', '✏️ Category updated successfully!');
    }

    public function destroy(Request $request)
    {
        $cat = Category::findOrFail($request->catagory_id);
        $cat->delete();
        return Redirect::route('category.index')->with('danger', '🗑️ Category deleted successfully!');
    }
}
