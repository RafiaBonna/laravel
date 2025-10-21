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
            <a href="/dash" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          {{-- 2. Users Management (Icon changed to a Box icon) --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}"> 
              <i class="nav-icon fas fa-box"></i> 
              <p>Users Management</p>
            </a>
          </li>

          {{-- 3. Supplier (Icon changed to a Box icon) --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('supplier.index') }}">
              <i class="nav-icon fas fa-box"></i> 
              <p>Supplier</p>
            </a>
          </li>

       <li class="nav-item">
            {{-- Raw Material (Icon changed to a Box icon) --}}
            <a class="nav-link" href="{{ route('raw_material.index') }}">
              <i class="nav-icon fas fa-box"></i> 
              <p>Raw Material</p>
            </a>
          </li>
        <li class="nav-item">
    <a class="nav-link" href="{{ route('stockin.create') }}">
        <i class="nav-icon fas fa-box"></i>
        <p>Stock In</p>
    </a>
</li>
          
        </ul>
      </nav>
      </div>
    </aside>