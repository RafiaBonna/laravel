<?php
// app/Http/Controllers/Superadmin/StockController.php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\StockMovement; // ✅ StockMovement মডেল আমদানি
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the stock movements (Stock History).
     */
    public function index()
    {
        // সমস্ত স্টক মুভমেন্ট নিয়ে আসা এবং সাথে Raw Material, User, ও Reference ডকুমেন্ট লোড করা
        $stockMovements = StockMovement::with(['rawMaterial', 'user', 'reference'])
                                      ->latest() // নতুন মুভমেন্টগুলো আগে দেখাবে
                                      ->paginate(50); 
                                      
        // View: superadmin/stock/index.blade.php
        return view('superadmin.stock.index', compact('stockMovements'));
    }
    
    // এই কন্ট্রোলারে create, store, edit, update, destroy মেথডগুলোর প্রয়োজন নেই
    // কারণ Stock Movement অন্য ডকুমেন্ট (Receiving/Consumption) দ্বারা তৈরি হয়।
}