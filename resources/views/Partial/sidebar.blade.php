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

        @php
            $user = Auth::user();

        @endphp

        <nav class="mt-2">
            {{-- circle sidebar start from here  --}}



            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @if ($user->user_role == 'circle')
                    <li class="nav-item">
                        <a href="{{ route('circle.dashboard') }}" class="nav-link ">
                            <i class="nav-icon fas fa-home text-light"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.stock') }}" class="nav-link ">
                            <i class="nav-icon fas fa-list text-light"></i>
                            <p>
                                Stock
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.arrears') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt text-danger"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.collection.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.collection.index' || Route::currentRouteName() == 'circle.collection.create' || Route::currentRouteName() == 'circle.collection.search' ? 'active' : '' }}">
                            <i class="nav-icon fab fa-speakap text-warning"></i>
                            <p>
                                Collection
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.appeal.index') }}" class="nav-link ">
                            <i class="nav-icon fa fa-bookmark text-primary"></i>
                            <p>
                                Appeal
                            </p>
                        </a>
                    </li>
                @endif

                {{-- commissioner sidebar start from here   --}}
                @if ($user->user_role == 'commissioner')
                    <!-- Add icons to the links using the .nav-icon class
     with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('commissioner.dashboard') }}" class="nav-link ">
                            <i class="nav-icon fas fa-home text-light"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link ">
                            <i class="nav-icon fas fa-list text-light"></i>
                            <p>
                                Stock
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('commissioner.arrears') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt text-danger"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('commissioner.users') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.users' ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                SMS
                            </p>
                        </a>
                    </li>
                @endif




                {{-- technical sidebar start from here   --}}
                @if ($user->user_role == 'technical')
                    <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('technical.dashboard') }}" class="nav-link ">
                            <i class="nav-icon fas fa-home text-light"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link ">
                            <i class="nav-icon fas fa-list text-light"></i>
                            <p>
                                Stock
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('technical.arrears') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt text-danger"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>
                @endif





            {{-- Range sidebar start from here   --}}
            @if ($user->user_role == 'range')
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('range.dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-home text-light"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-list text-light"></i>
                        <p>
                            Stock
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('range.arrears') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-check-alt text-danger"></i>
                        <p>
                            Arrear
                        </p>
                    </a>
                </li>
            @endif

            <li class="nav-header">Profile</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  {{Auth::user()->name}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{ route('profile') }}" class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('passwordResetForm') }}" class="nav-link {{ Route::currentRouteName() == 'passwordResetForm' ? 'active' : '' }}" >
                    <i class="far fa-circle nav-icon"></i>
                    <p>Password Reset</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Log Out</p>

                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
              </ul>
            </li>



          </ul>

        </nav>











        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
