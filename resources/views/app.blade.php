<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link href="{{ asset('jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />



  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed {{ (config('settings.sidebar_collapse'))? 'sidebar-collapse':'' }}">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
     @include('Partial.topbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('Partial.sidebar')

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper" >

    
      @yield('content')
   

  </div>


  <!-- /.content-wrapper -->

  @include('Partial.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

 <!-- Toast js -->

<script src="{{ asset('jquery-toast/jquery.toast.min.js') }}"></script>
<!-- toastr init js-->
<script src="{{ asset('jquery-toast/toastr.init.js') }}"></script>




<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
  $('#deadline, #audit_date, #expire_date, #deadline, #reopen_date, #disposal_date, #pay_date, #po_challan_date, #issue_date, #hearing_date, #from_date, #to_date').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    weekStart: 5
  });
</script>

<script>
  @if (Session::has('message'))

      var type = ("{{ Session::get('type') }}");

      var message = ("{{ Session::get('message') }}");
      switch (type) {
      case 'success':
      toastr.success(message);
      break;
      case 'warning':
      toastr.warning(message);
      break;
      case 'error':
      toastr.error(message);
      break;
      case 'info':
      toastr.info(message);
      break;
      }

  @endif


</script>
@stack('js')

</body>
</html>
