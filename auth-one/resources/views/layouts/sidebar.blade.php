<?php
// sidebar.blade.php

// Note: এই ফাইলটিতে Superadmin, Depo, এবং Distributor-এর জন্য আলাদা নেভিগেশন লিংকগুলো থাকবে। 
// Auth::user()->hasRole() চেক করে প্রতিটি রোল অনুযায়ী নেভিগেশন দেখাবে।
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
                {{-- Display logged-in user's name and role (Using getPrimaryRole() helper) --}}
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Guest' }} ({{ ucfirst(Auth::user()->getPrimaryRole() ?? 'Guest') }})</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard Link (Common for all roles) --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                {{-- ----------------------------------------------------------------- --}}
                {{--                        SUPERADMIN MENU (ROLE: superadmin)           --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('superadmin'))
                    <li class="nav-header">ADMINISTRATION</li>
                    
                    {{-- ✅ 1. User Management --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.users.index') }}" class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    
                    {{-- 2. MASTER SETUP SUB-MENU --}}
                    <li class="nav-item {{ request()->routeIs('superadmin.depos.*') || request()->routeIs('superadmin.distributors.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('superadmin.depos.*') || request()->routeIs('superadmin.distributors.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Setup
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                {{-- Master Setup-এর জন্য আপনার Route Name ব্যবহার করুন --}}
                                <a href="{{-- route('superadmin.depos.index') --}}" class="nav-link {{ request()->routeIs('superadmin.depos.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Depo Setup</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{-- route('superadmin.distributors.index') --}}" class="nav-link {{ request()->routeIs('superadmin.distributors.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Distributor Setup</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{-- ----------------------------------------------------------------- --}}
                {{--                        DEPO MENU (ROLE: depo)                     --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('depo'))
                    <li class="nav-header">DEPO MANAGEMENT</li>
                    
                    <li class="nav-item">
                        {{-- Distributor Management Route --}}
                        <a href="{{-- route('depo.distributors.index') --}}" class="nav-link"> 
                            <i class="nav-icon fas fa-people-carry"></i> 
                            <p>Distributor Management</p>
                        </a>
                    </li>
                    
                    {{-- Other Placeholder Links --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-box"></i> 
                            <p>Stock & Inventory</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-file-invoice"></i> 
                            <p>Reports</p>
                        </a>
                    </li>
                @endif


                {{-- ----------------------------------------------------------------- --}}
                {{--                     DISTRIBUTOR MENU (ROLE: distributor)            --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('distributor'))
                    <li class="nav-header">SALES & CUSTOMERS</li>
                    <li class="nav-item">
                        {{-- Customer Management Route --}}
                        <a href="{{-- route('distributor.customers.index') --}}" class="nav-link"> 
                            <i class="nav-icon fas fa-address-book"></i> 
                            <p>Customer Management</p>
                        </a>
                    </li>
                    {{-- Other Placeholder Links --}}
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