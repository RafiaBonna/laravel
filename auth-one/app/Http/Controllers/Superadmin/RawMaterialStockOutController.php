<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawMaterialStockOutController extends Controller
{
    public function index()
    {
        return view('superadmin.raw_material_stock_out.index');
    }
}
