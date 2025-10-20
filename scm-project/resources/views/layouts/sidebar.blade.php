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

          {{-- 1. Dashboard --}}
          {{-- AdminLTE standard: nav link must be inside li.nav-item --}}
          <li class="nav-item"> 
            <a href="/dash" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          {{-- 2. Users Management --}}
          <li class="nav-item">
            {{-- User list page-এ পয়েন্ট করা হলো (route: user.index) --}}
            <a class="nav-link" href="{{ route('user.index') }}"> 
              <i class="far fa-circle nav-icon"></i>
              <p>Users Management</p>
            </a>
          </li>

          {{-- 3. Supplier Management --}}
          <li class="nav-item">
            {{-- Supplier list page-এ পয়েন্ট করা হলো (route: supplier.index) --}}
            <a class="nav-link" href="{{ route('supplier.index') }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Supplier</p>
            </a>
          </li>

       <li class="nav-item">
            {{-- Supplier list page-এ পয়েন্ট করা হলো (route: supplier.index) --}}
            <a class="nav-link" href="{{ route('raw_material.index') }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Raw Material</p>
            </a>
          </li>


          
        </ul>
      </nav>
      </div>
    </aside>