<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Admin Dashboard
    public function adminIndex()
    {
        return view('pages.dashboard.admin_index');
    }

    // Distributor Dashboard
    public function distributorIndex()
    {
        return view('pages.dashboard.distributor_index');
    }

    // Depo Dashboard
    public function depoIndex()
    {
        return view('pages.dashboard.depo_index');
    }

    // Default Home Page (যদি রোল না পায়)
    public function home()
    {
        return view('pages.dashboard.home');
    }
}