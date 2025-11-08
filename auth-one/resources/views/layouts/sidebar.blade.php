<?php
// sidebar.blade.php
// ... (ফাইলটির প্রথম অংশ অপরিবর্তিত) ...
?>
<aside class="main-sidebar sidebar-dark-indigo elevation-4">
    {{-- Brand Logo and Name --}}
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SCM PANEL</span>
    </a>

    <div class="sidebar">
        {{-- User Panel --}}
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

        {{-- Sidebar Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard Link (Common for all roles) --}}
                <li class="nav-item">
                    {{-- প্রতিটি রোলের জন্য নির্দিষ্ট ড্যাশবোর্ড রুটে যাবে --}}
                    <a href="{{ route(Auth::user()->getPrimaryRole() . '.dashboard') }}" class="nav-link {{ request()->routeIs('*dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i> 
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ----------------------------------------------------------------- --}}
                {{--                       SUPERADMIN LINKS                            --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('superadmin'))
                    <li class="nav-header">ADMINISTRATION</li>

                    {{-- User Management --}}
                    <li class="nav-item">
                        <a href="{{ route('superadmin.users.index') }}" class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i> 
                            <p>User Management</p>
                        </a>
                    </li>

                    {{-- Product Management (Placeholder) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> 
                            <i class="nav-icon fas fa-box-open"></i> 
                            <p>Product Management</p>
                        </a>
                    </li>
                    
                    {{-- Settings Menu (Treeview) --}}
                    @php
                        $isSettingsActive = request()->routeIs('superadmin.suppliers.*'); // এখানে অন্যান্য Settings রুট যোগ করা যেতে পারে
                    @endphp
                    <li class="nav-item {{ $isSettingsActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isSettingsActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                **Settings**
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- Supplier List Sub-menu --}}
                            <li class="nav-item">
                                {{-- ধরে নেওয়া হলো Supplier List-এর রুট হলো 'superadmin.suppliers.index' --}}
                                <a href="{{ route('superadmin.suppliers.index') }}" class="nav-link {{ request()->routeIs('superadmin.suppliers.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier List</p>
                                </a>
                            </li>
                            {{-- অন্য কোনো সেটিংস সাব-মেনু থাকলে এখানে যোগ হবে --}}
                        </ul>
                    </li>
                @endif
                
                {{-- ----------------------------------------------------------------- --}}
                {{--                           DEPO LINKS (অপরিবর্তিত)                      --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('depo'))
                    <li class="nav-header">DEPO MANAGEMENT</li>
                    
                    {{-- Distributor Management (Route: depo.users.index) --}}
                    <li class="nav-item">
                        <a href="{{ route('depo.users.index') }}" class="nav-link {{ request()->routeIs('depo.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck-loading"></i> 
                            <p>Distributor Management</p>
                        </a>
                    </li>

                    {{-- Stock/Inventory (Placeholder) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> 
                            <i class="nav-icon fas fa-boxes"></i> 
                            <p>Stock/Inventory</p>
                        </a>
                    </li>
                @endif
                
                {{-- ----------------------------------------------------------------- --}}
                {{--                         DISTRIBUTOR LINKS (অপরিবর্তিত)                 --}}
                {{-- ----------------------------------------------------------------- --}}
                @if (Auth::user()->hasRole('distributor'))
                    <li class="nav-header">DISTRIBUTOR OPERATIONS</li>

                    {{-- Customer Management (Placeholder/Future Route) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> 
                            <i class="nav-icon fas fa-users-cog"></i> 
                            <p>Customer Management</p>
                        </a>
                    </li>

                    {{-- Sales/Invoices (Placeholder) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> 
                            <i class="nav-icon fas fa-file-invoice-dollar"></i> 
                            <p>Sales/Invoices</p>
                        </a>
                    </li>
                    
                    {{-- Payments (Placeholder) --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> 
                            <i class="nav-icon fas fa-money-check-alt"></i> 
                            <p>Payments</p>
                        </a>
                    </li>
                @endif

                {{-- ----------------------------------------------------------------- --}}
                {{--                           LOGOUT BUTTON (অপরিবর্তিত)                     --}}
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