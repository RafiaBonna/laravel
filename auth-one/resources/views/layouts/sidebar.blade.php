<?php
// sidebar.blade.php

// Note: এই ফাইলটিতে Superadmin, Depo, এবং Distributor-এর জন্য আলাদা নেভিগেশন লিংকগুলো থাকবে। 
// Auth::user()->role চেক করে প্রতিটি রোল অনুযায়ী নেভিগেশন দেখাবে।
?>
<aside class="main-sidebar sidebar-dark-indigo elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SCM PANEL</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- User image placeholder --}}
                <img src="{{ asset('admin/dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                {{-- Display logged-in user's name and role --}}
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Guest' }} ({{ ucfirst(Auth::user()->role ?? 'Guest') }})</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard Link (Common for all roles) --}}
                <li class="nav-item"> 
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}"> 
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                {{-- ----------------------------------------------------------------- --}}
                {{--                           SUPERADMIN NAVIGATION                     --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->role === 'superadmin')
                    <li class="nav-header">ADMINISTRATION</li>
                    
                    {{-- Depo Management (নতুন যুক্ত করা হয়েছে) --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.depos.index') }}" class="nav-link {{ request()->routeIs('superadmin.depos.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-warehouse"></i> 
                            <p>Depo Management</p>
                        </a>
                    </li>
                    
                    {{-- User Management --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.users.index') }}" class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-users"></i> 
                            <p>User Management</p>
                        </a>
                    </li>
                    
                    <li class="nav-header">RAW MATERIAL MANAGEMENT</li>
                    
                    {{-- Raw Material Category --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.raw_materials.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw_materials.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-layer-group"></i> 
                            <p>Raw Materials</p>
                        </a>
                    </li>

                    {{-- Raw Material Receiving (Stock In) --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.raw_material_receivings.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw_material_receivings.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-arrow-down"></i> 
                            <p>Stock In (Receiving)</p>
                        </a>
                    </li>

                    {{-- Raw Material Consumption --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.raw_material_consumptions.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw_material_consumptions.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-truck-loading"></i> 
                            <p>Consumption (Production)</p>
                        </a>
                    </li>

                    {{-- Raw Material Shipments (Stock Out / Transfer Out) (নতুন যুক্ত করা হয়েছে) --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.raw_material_shipments.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw_material_shipments.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-shipping-fast"></i> 
                            <p>Shipments (Transfer Out)</p>
                        </a>
                    </li>
                @endif
                
                {{-- ----------------------------------------------------------------- --}}
                {{--                           DEPO NAVIGATION                           --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->role === 'depo')
                    <li class="nav-header">DEPO OPERATIONS</li>

                    {{-- Incoming Shipments (Receive) (নতুন যুক্ত করা হয়েছে) --}}
                    <li class="nav-item">
                        <a href="{{ route('depo.shipments.index') }}" class="nav-link {{ request()->routeIs('depo.shipments.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-box-open"></i> 
                            <p>Incoming Shipments (Receive)</p>
                        </a>
                    </li>

                    {{-- Depo Stock (Placeholder) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-warehouse"></i> 
                            <p>Current Depo Stock</p>
                        </a>
                    </li>
                    
                    {{-- Distributor Management --}}
                    <li class="nav-item">
                        <a href="{{ route('depo.users.index') }}" class="nav-link {{ request()->routeIs('depo.users.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-users"></i> 
                            <p>Distributor Management</p>
                        </a>
                    </li>
                    
                    {{-- Other Placeholder Links from ERD --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-clipboard-list"></i> 
                            <p>Sales Order Processing</p>
                        </a>
                    </li>
                @endif

                {{-- ----------------------------------------------------------------- --}}
                {{--                         DISTRIBUTOR NAVIGATION                      --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->role === 'distributor')
                    <li class="nav-header">DISTRIBUTOR OPERATIONS</li>
                    
                    {{-- Customer Management --}}
                    <li class="nav-item">
                        <a href="{{ route('distributor.customers.index') }}" class="nav-link {{ request()->routeIs('distributor.customers.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-handshake"></i> 
                            <p>Customer Management</p>
                        </a>
                    </li>
                    {{-- Other Placeholder Links from ERD --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-file-invoice-dollar"></i> 
                            <p>Sales/Invoices</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-money-check-alt"></i> 
                            <p>Payments</p>
                        </a>
                    </li>
                @endif

                {{-- ----------------------------------------------------------------- --}}
                {{--                           LOGOUT BUTTON                             --}}
                {{-- ----------------------------------------------------------------- --}}
                <li class="nav-header">ACCOUNT</li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
