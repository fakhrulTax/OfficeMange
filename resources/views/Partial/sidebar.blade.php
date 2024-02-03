<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('circle.dashboard') }}" class="brand-link elevation-4">
                <img src="{{ asset('img/logo.png') }}" class="img-circle elevation-2" alt="User Image" style="width: 55px">
                <span class="brand-text font-weight-light" style="font-size: 16px"></span>


            </a>
        </div>

        @php
            $name = Auth::user()->name;

            if(strlen($name) > 15){
                $words = explode(' ', $name);

                $name = implode(' ', array_slice($words, 0, 2));
         
            }

         

        @endphp

        <div class="col-md-8 mt-3">
            <h4 class="brand-text font-weight-light text-light" style="font-size: 18px">
                {{ ucfirst($name) }}</h4>

            <h4 class="brand-text font-weight-light text-light" style="font-size: 18px">
                {{ ucfirst(Auth::user()->designation) }}</h4>
        </div>

    </div>


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
                        <a href="{{ route('circle.dashboard') }}" class="nav-link {{ Route::currentRouteName() == 'circle.dashboard' ? 'active' : ''}} ">
                            <i class="nav-icon fas fa-home text-light"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.task.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.task.index' ? 'active' : '' }}">
                            <i class="nav-icon fab fa-dailymotion text-light"></i>
                            <p>
                                Forward Dairy
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.stock') }}" class="nav-link {{ Route::currentRouteName() == 'circle.stock' ? 'active' : ''}} ">
                            <i class="nav-icon fas fa-list text-light"></i>
                            <p>
                                Stock
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.arrears') }}" class="nav-link {{ Route::currentRouteName() == 'circle.arrears' ? 'active' : ''}}">
                            <i class="nav-icon fas fa-money-check-alt text-light"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.collection.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.collection.index' || Route::currentRouteName() == 'circle.collection.create' || Route::currentRouteName() == 'circle.collection.search' ? 'active' : '' }}">
                            <i class="nav-icon fab fa-speakap text-light"></i>
                            <p>
                                Collection
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.appeal.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.appeal.index' || Route::currentRouteName() == 'circle.appeal.create' || Route::currentRouteName() == 'circle.appeal.search' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-bookmark text-light"></i>
                            <p>
                                Appeal
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-folder text-light"></i>
                            <p>
                                ReOpen
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-calculator text-light"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-file text-light"></i>
                            <p>
                                Sonchoy Potra
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('circle.movement.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.movement.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-running text-light"></i>
                            <p>
                                Movement
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('circle.setting.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'circle.setting.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Settings
                            </p>
                        </a>
                    </li>
                @endif

                {{-- commissioner sidebar start from here   --}}
                @if ($user->user_role == 'commissioner')
                    <!-- Add icons to the links using the .nav-icon class
     with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('commissioner.dashboard') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.dashboard' ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-home text-light"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('commissioner.task.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.task.index' ? 'active' : '' }}">
                            <i class="nav-icon fab fa-dailymotion text-light"></i>
                            <p>
                                Forward Dairy
                            </p>
                        </a>
                    </li>

           

                    <li class="nav-item">
                        <a href="{{ route('commissioner.arrears', 'all') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.arrears' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt text-light"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('commissioner.collection.index') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.collection.index' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt text-light"></i>
                            <p>
                                Collection
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-folder text-light"></i>
                            <p>
                                ReOpen
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-calculator text-light"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-file text-light"></i>
                            <p>
                                Sonchoy Potra
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('commissioner.users') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.users' ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-users text-light"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('commissioner.sms') }}"
                            class="nav-link {{ Route::currentRouteName() == 'commissioner.sms' ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-envelope text-light"></i>
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
                        <a href="{{ route('technical.dashboard') }}" class="nav-link {{ Route::currentRouteName() == 'technical.dashboard' ? 'active' : '' }} ">
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
                        <a href="{{ route('technical.arrears', 'all') }}" class="nav-link {{ Route::currentRouteName() == 'technical.arrears' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt text-light"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-folder text-light"></i>
                            <p>
                                ReOpen
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-calculator text-light"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-file text-light"></i>
                            <p>
                                Sonchoy Potra
                            </p>
                        </a>
                    </li>
                @endif





                {{-- Range sidebar start from here   --}}
                @if ($user->user_role == 'range')
                    <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('range.dashboard') }}"
                            class="nav-link {{ Route::currentRouteName() == 'range.dashboard' ? 'active' : '' }} ">
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
                        <a href="{{ route('range.arrears', 'all') }}"
                            class="nav-link {{ Route::currentRouteName() == 'range.arrears' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt text-light"></i>
                            <p>
                                Arrear
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-folder text-light"></i>
                            <p>
                                ReOpen
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-calculator text-light"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=" "
                            class="nav-link ">
                            <i class="nav-icon fa fa-file text-light"></i>
                            <p>
                                Sonchoy Potra
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Profile</li>
                <li class="nav-item {{ Route::currentRouteName() == 'passwordResetForm' ||Route::currentRouteName() == 'profile' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user text-light"></i>
                        <p>
                            {{ ucfirst($name) }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('profile') }}"
                                class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : ''  }}">
                                <i class="far fa-circle nav-icon text-light"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('passwordResetForm') }}"
                                class="nav-link {{ Route::currentRouteName() == 'passwordResetForm' }}">
                                <i class="far fa-circle nav-icon text-light"></i>
                                <p>Password Reset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Log Out</p>

                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf</form>
                        </li>
                    </ul>
                </li>



            </ul>

        </nav>











        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
