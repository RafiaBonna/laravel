<aside class="main-sidebar 	sidebar-dark-indigo elevation-4">
    <a href="index.html" class="brand-link">
      <img src="admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CONTROL PANEL</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="admin/dist/img/photo3.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">ADMIN</a>
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

          {{-- 1. Dashboard (Icon KEPT as fas fa-tachometer-alt) --}}
        <li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Users Management</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck"></i>
        <p>Supplier</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('raw_material.index') }}" class="nav-link {{ request()->routeIs('raw_material.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cubes"></i>
        <p>Raw Material</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('stockin.index') }}" class="nav-link {{ request()->routeIs('stockin.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-arrow-circle-down"></i>
        <p>Stock In</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('stockout.index') }}" class="nav-link {{ request()->routeIs('stockout.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-arrow-circle-up"></i>
        <p>Stock Out</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('depot.index') }}" class="nav-link {{ request()->routeIs('depot.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-warehouse"></i>
        <p>Depot Management</p>
    </a>
</li>

        </ul>
      </nav>
      </div>
    </aside>