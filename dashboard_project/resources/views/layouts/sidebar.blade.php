<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img
        src="{{ asset('dist/assets/img/AdminLTELogo.png') }}" 
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
      />
      <span class="brand-text fw-light">AdminLTE 4</span>
      </a>
    </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="navigation"
        aria-label="Main navigation"
        data-accordion="false"
        id="navigation"
      >
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link active"> 
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">SCM MODULES</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>Inventory</p>
            </a>
          </li>
      </ul>
      </nav>
  </div>
  </aside>