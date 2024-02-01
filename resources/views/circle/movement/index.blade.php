@extends('app')
@section('title',$title)
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                    <h1 class="m-0">Movement Register</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                       
                        
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">

        @if( isset($editMovement) )
            @include('circle.movement.edit')
        @elseif( isset($receiveMovement) )
            @include('circle.movement.receive')
        @else              
            @include('circle.movement.create')    
        @endif


        <div class="card">

             @if( count($movements) < 1  )

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->
            <div class="card-body">
                <table id="movement_table" class="table table-primary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIN & Name</th>
                            <th>Moved Date</th>
                            <th>Office Name</th>
                            <th>Receive Date</th>
                            <th>Circle</th>
                            <th>Option</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($movements as $key => $movement)
                      <tr>
                        <td>{{ ++$key }}</td>                        
                        <td>
                            {{ $movement->tin }}<br>
                            {{ $movement->stock->name }}
                        </td>
                        <td> {{ date('d-m-Y', strtotime($movement->move_date)) }} </td>
                        <td> {{ ucfirst($movement->office_name) }} </td>
                        <td>
                            @if( $movement->receive_date != null )

                            {{ date('d-m-Y', strtotime($movement->receive_date)) }}

                            @else

                            <a href="{{ route('circle.movement.receive', $movement->id) }}" class="btn btn-sm btn-success">Receive</a>

                            @endif
                        </td>
                        <td>  {{ 'circle-'.$movement->circle }} </td>
                        <td> <a href="{{ route('circle.movement.edit', $movement->id) }}" class="btn btn-sm btn-danger">Edit</a></td>
                      </tr>
                    @endforeach

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
-

            @endif

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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>     
            $(document).ready(function() {

                $(function() {
            $("#movement_table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#movement_table_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
               
                $('#assessment_year').select2({
                    placeholder: 'Select All Assessment Year'
                });


            });
    

    </script>

@endpush