<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- Brand Logo --}}
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="SCM Logo"
             class="brand-image img-circle elevation-3" style="opacity:.9; background:white;">
        <span class="brand-text font-weight-bold text-uppercase">SCM Panel</span>
    </a>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- User Info --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom">
            <div class="image">
                <img src="{{ asset('admin/dist/img/photo3.jpg') }}" class="img-circle elevation-2" alt="User">
            </div>
            <div class="info">
                <a href="#" class="d-block fw-semibold text-white">
                    {{ Auth::user()->name ?? 'Guest' }}
                    <small class="d-block text-muted" style="font-size: 12px;">
                        {{ ucfirst(Auth::user()->getPrimaryRole() ?? 'Guest') }}
                    </small>
                </a>
            </div>
        </div>

        {{-- Sidebar Menu --}}
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item mb-1">
                    <a href="{{ route(Auth::user()->getPrimaryRole() . '.dashboard') }}"
                       class="nav-link {{ request()->routeIs(Auth::user()->getPrimaryRole() . '.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ================= Superadmin Section ================= --}}
                @if (Auth::user()->hasRole('superadmin'))
                    <li class="nav-header text-uppercase text-sm text-secondary mt-3 mb-1">Administration</li>

                    {{-- User Management --}}
                    <li class="nav-item mb-1">
                        <a href="{{ route('superadmin.users.index') }}"
                           class="nav-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    
                    {{-- 📦 Raw Material Section (NEWLY ADDED) --}}
                    <?php
                        $rawMaterialRoutes = [
                            'superadmin.raw-materials.*', 
                            'superadmin.raw-material-purchases.*',
                            'superadmin.raw-material-stock-out.*',
                            'superadmin.raw-material-stock.index',
                            'superadmin.wastage.*'
                        ];
                        $isRawMaterialActive = in_array(true, array_map(fn($route) => request()->routeIs($route), $rawMaterialRoutes));
                    ?>
                    
                    <li class="nav-item {{ $isRawMaterialActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isRawMaterialActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Raw Material <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- ✅ Material List Sub-Menu --}}
                            <li class="nav-item">
                                <a href="{{ route('superadmin.raw-materials.index') }}"
                                   class="nav-link {{ request()->routeIs('superadmin.raw-materials.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Material List</p>
                                </a>
                            </li>
                            {{-- Stock In Sub-menus (Placeholder) --}}
                            <li class="nav-item">
                                <a href="{{ route('superadmin.raw-material-purchases.create') }}" class="nav-link {{ request()->routeIs('superadmin.raw-material-purchases.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock In (Purchase)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.raw-material-purchases.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw-material-purchases.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock In Invoice</p>
                                </a>
                            </li>
                            {{-- Stock Out Sub-menus (Placeholder) --}}
                            <li class="nav-item">
                                <a href="{{ route('superadmin.raw-material-stock-out.create') }}" class="nav-link {{ request()->routeIs('superadmin.raw-material-stock-out.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock Out (Issue)</p>
                                </a>
                            </li>
                            {{-- Stock Report & Wastage (Placeholder) --}}
                            <li class="nav-item">
                                <a href="{{ route('superadmin.raw-material-stock.index') }}" class="nav-link {{ request()->routeIs('superadmin.raw-material-stock.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.wastage.index') }}" class="nav-link {{ request()->routeIs('superadmin.wastage.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Wastage Entry/List</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{-- Settings Section --}}
                    <?php
                        $settingsRoutes = ['superadmin.suppliers.*', 'superadmin.depo.index']; // Note: 'superadmin.depos.*' was changed to 'superadmin.depo.index' based on superadmin.php route
                        $isSettingsActive = in_array(true, array_map(fn($route) => request()->routeIs($route), $settingsRoutes));
                    ?>

                    <li class="nav-item {{ $isSettingsActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isSettingsActive ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Settings <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('superadmin.suppliers.index') }}"
                                   class="nav-link {{ request()->routeIs('superadmin.suppliers.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('superadmin.depo.index') }}" class="nav-link {{ request()->routeIs('superadmin.depo.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Depo List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- ================= Depo Section ================= --}}
                @if (Auth::user()->hasRole('depo'))
                    <li class="nav-header text-uppercase text-sm text-secondary mt-3 mb-1">Depo Management</li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('depo.users.index') }}"
                           class="nav-link {{ request()->routeIs('depo.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Distributor Management</p>
                        </a>
                    </li>
                @endif

                {{-- ================= Distributor Section ================= --}}
                @if (Auth::user()->hasRole('distributor'))
                    <li class="nav-header text-uppercase text-sm text-secondary mt-3 mb-1">Distributor Panel</li>
                    <li class="nav-item mb-1">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Customer List</p>
                        </a>
                    </li>
                @endif

                {{-- ================= Logout ================= --}}
                <li class="nav-header text-uppercase text-sm text-secondary mt-4 mb-1">Account</li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link text-danger"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>

{{-- Optional CSS tweaks for clean look --}}
<style>
    .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #1e3a8a !important;
        color: #fff !important;
    }
    .nav-sidebar>.nav-item>.nav-link:hover {
        background-color: #334155 !important;
        color: #fff !important;
    }
    .nav-header {
        letter-spacing: .5px;
        font-weight: 600;
    }
</style>