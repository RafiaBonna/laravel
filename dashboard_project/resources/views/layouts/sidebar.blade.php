<!-- resources/views/layouts/sidebar.blade.php -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel -->
        @if(Auth::check())
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard Link -->
                <li class="nav-item">
                    @if(Auth::check() && Auth::user())
                        <a href="{{ Auth::user()->getDashboardRoute() }}" 
                           class="nav-link @if(Request::is('*dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>Login</p>
                        </a>
                    @endif
                </li>

                <!-- -----------------------------------------------
                     ADMIN ONLY MENUS
                ------------------------------------------------- -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-header">ADMINISTRATION</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" 
                           class="nav-link @if(Request::is('admin/users*')) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                @endif

                <!-- Distributor Menu -->
                @if(Auth::check() && Auth::user()->role === 'distributor')
                    <li class="nav-header">DISTRIBUTOR MENU</li>
                    <li class="nav-item">
                        <a href="{{ route('distributor.dashboard') }}" 
                           class="nav-link @if(Request::is('distributor/dashboard')) active @endif">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Distributor Dashboard</p>
                        </a>
                    </li>
                @endif

                <!-- Depo Menu -->
                @if(Auth::check() && Auth::user()->role === 'depo')
                    <li class="nav-header">DEPO MENU</li>
                    <li class="nav-item">
                        <a href="{{ route('depo.dashboard') }}" 
                           class="nav-link @if(Request::is('depo/dashboard')) active @endif">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Depo Dashboard</p>
                        </a>
                    </li>
                @endif

                <!-- Logout -->
                @if(Auth::check())
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                           class="nav-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
