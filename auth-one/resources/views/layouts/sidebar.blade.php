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
                {{--                       SUPERADMIN LINKS                              --}}
                {{-- ----------------------------------------------------------------- --}}
                @if(Auth::check() && Auth::user()->role === 'superadmin')
                    <li class="nav-header">SUPERADMIN MANAGEMENT</li>
                    <li class="nav-item">
                        {{-- ✅ User Management (Superadmin manages Depo/Distributor roles) --}}
                        <a href="{{ route('superadmin.users.index') }}" class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-users"></i> 
                            <p>User Management</p>
                        </a>
                    </li>
                    
                    {{-- Other Placeholder Links from ERD --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-truck"></i> 
                            <p>Suppliers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-boxes"></i> 
                            <p>Raw Materials</p>
                        </a>
                    </li>
                @endif
                
                ---

                {{-- ----------------------------------------------------------------- --}}
                {{--                            DEPO LINKS                               --}}
                {{-- ----------------------------------------------------------------- --}}
                @if(Auth::check() && Auth::user()->role === 'depo')
                    <li class="nav-header">DEPO MANAGEMENT</li>
                    <li class="nav-item">
                        {{-- ✅ Distributor Management (Depo manages Distributors) --}}
                        <a href="{{ route('depo.users.index') }}" class="nav-link {{ request()->routeIs('depo.users.*') ? 'active' : '' }}"> 
                            <i class="nav-icon fas fa-user-friends"></i> 
                            <p>Distributor Management</p>
                        </a>
                    </li>
                    {{-- Other Placeholder Links from ERD --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fas fa-warehouse"></i> 
                            <p>Depot Stock</p>
                        </a>
                    </li>
                @endif

                ---

                {{-- ----------------------------------------------------------------- --}}
                {{--                         DISTRIBUTOR LINKS                             --}}
                {{-- ----------------------------------------------------------------- --}}
                @if(Auth::check() && Auth::user()->role === 'distributor')
                    <li class="nav-header">DISTRIBUTOR MANAGEMENT</li>
                    <li class="nav-item">
                        {{-- ✅ Customer Management (Distributor manages Customers) --}}
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
                @endif

                ---

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