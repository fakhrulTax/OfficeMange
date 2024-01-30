@extends('app')

@section('title', 'User List')

@push('css')
    <!--  Datatable -->

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User List </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
            

                            <a href="{{ route('commissioner.user.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add New User</a>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                       
                        <tr>
                            <th>#</th>
                            <th>User Type</th>
                            <th>Name & Designation</th>
                            <th>Range</th>
                            <th>Circle</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            
                            <th>Action</th>
                        </tr>
                            
                      
                        
                    </thead>
                    <tbody>

                        @foreach ($users as $key => $user) 
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{ $user->user_role }}</td>
                            <td>
                                {{ ucfirst($user->name) }}
                                <br>
                                {{ ucfirst($user->designation) }}
                            
                            </td>
                            <td>@if($user->range) Range {{$user->range}} @endif</td>
                            <td>@if($user->circle) Circle {{$user->circle}} @endif</td>
                            <td>{{$user->mobile_number }}</td>
                            <td>{{$user->email}}</td>
                  
                            <td>
                                <a href="{{ route('commissioner.user.edit', $user->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('commissioner.user.delete', $user->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                        @endforeach
                        



                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->



    </section>

@endsection






        @push('js')
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- AdminLTE App -->



        <script>
            $(function() {
                $("#userTable").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');
                
            });

           
        </script>


        
        @endpush