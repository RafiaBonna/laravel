<aside class="main-sidebar sidebar-dark-indigo elevation-4">
  <a href="/" class="brand-link">
    <img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SCM Project</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('admin/dist/img/photo3.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        @auth
            <a href="{{ Auth::user()->getDashboardRoute() }}" class="d-block">{{ strtoupper(Auth::user()->role) }} PANEL</a>
        @endauth
        @guest
            <a href="#" class="d-block">GUEST</a>
        @endguest
      </div>
    </div>

    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
            <a href="{{ Auth::user()->getDashboardRoute() }}" class="nav-link @if(Request::is('*dashboard')) active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        {{-- ------------------------------------------------ --}}
        {{-- ২. ADMIN ONLY MENUS --}}
        {{-- ------------------------------------------------ --}}
        @if (Auth::check() && Auth::user()->role === 'admin')
            <li class="nav-header">ADMINISTRATION</li>

            <li class="nav-item">
              <a class="nav-link @if(Request::is('admin/users*')) active @endif" href="{{ route('admin.users.index') }}">
                <i class="nav-icon fas fa-users"></i>
                <p>User Management</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>Depot Management</p>
              </a>
            </li>
        @endif

        {{-- ------------------------------------------------ --}}
        {{-- ৩. DISTRIBUTOR ONLY MENUS --}}
        {{-- ------------------------------------------------ --}}
        @if (Auth::check() && Auth::user()->role === 'distributor')
            <li class="nav-header">DISTRIBUTOR PANEL</li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon fas fa-truck"></i>
                <p>My Orders</p>
              </a>
            </li>
        @endif

        {{-- ------------------------------------------------ --}}
        {{-- ৪. DEPO ONLY MENUS --}}
        {{-- ------------------------------------------------ --}}
        @if (Auth::check() && Auth::user()->role === 'depo')
            <li class="nav-header">DEPO PANEL</li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon fas fa-box-open"></i>
                <p>Stock In/Out</p>
              </a>
            </li>
        @endif
        
        <li class="nav-header">LOGOUT</li>
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
      </ul>
    </nav>
    </div>
  </aside>