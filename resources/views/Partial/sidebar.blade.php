<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('circle.dashboard') }}" class="brand-link elevation-4">      
          <img src="{{ asset('img/logo.png') }}" class="img-circle elevation-2" alt="User Image" style="width: 55px">
      <span class="brand-text font-weight-light" style="font-size: 16px"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!--
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ config('settings.circle_name') }}</a>
        </div>
      </div>
-->
        <!-- SidebarSearch Form -->
        <!---
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="tin" placeholder="TIN" aria-label="Search" placeholder="TIN">
            <div class="input-group-append">
              <button  type="submit" class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        --->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('circle.dashboard') }}" class="nav-link ">
              <i class="nav-icon fas fa-home text-light"></i>
              <p>
                Home
              </p>
            </a>
          </li>   
          
          <li class="nav-item">
            <a href="{{route('circle.stock')}}" class="nav-link ">
              <i class="nav-icon fas fa-list text-light"></i>
              <p>
                Stock
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt text-danger"></i>
              <p>
                Arrear
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>