 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  
      <!-- Assessment Year -->
      @if (Auth::check() && Auth::user()->user_role == 'commissioner')
    <div class="navbar-nav ml-5">       
     
        <form class="form-inline" action="{{ route('commissioner.setting.update.assessment') }}" method="POST">
              @csrf
              <div class="form-group mx-sm-3 mb-2">
                  <label for="assessment_year" class="sr-only">Assessment Year</label>
                  
                  @php
                    $current_assessment_year = App\Helpers\MyHelper::currentAssessmentYear('01-07-2024');
                    $set_assessment_year = config('settings.assessment_year_commissioner');
                  @endphp

                  <select name="assessment_year" id="assessment_year" class="form-control">
                    @for($i = 0; $i < 3; $i++)
                      <option value="{{$current_assessment_year}}" {{ $current_assessment_year == $set_assessment_year ? 'selected' : '' }}>{{ App\Helpers\MyHelper::assessment_year_format($current_assessment_year) }}</option>
                      <?php $current_assessment_year -= 10001; ?>
                    @endfor
                  </select>

              </div>

              <button type="submit" class="btn btn-primary mb-2">save</button>

          </form>      
    </div>
    @endif

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
        
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Pending Task</span>
          <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i>  Pending Task
          </a>
          <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item dropdown-footer">See Forward Dairy</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">              
              <p>
                Logout
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
          </li>
    </ul>
  </nav>