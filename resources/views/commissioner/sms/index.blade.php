@extends('app')
@section('title', 'SMS')
@push('css')
    <!--  Datatable -->

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('content')



<section class="content">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SMS List</h1>
                </div>
                
            </div>
        </div>

    </div>




    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Receiver</th>
                        <th>SMS</th>
                        <th>Response Code</th>
                        <th>Response Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($smsInfo as $key => $sms )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $sms->sms_type }}</td>
                            <td>{{ $sms->receiver_number }}</td>
                            <td>{{ $sms->sms_body }}</td>
                            @php
                                $response = json_decode($sms->response);
                            @endphp
                            <td>{{ isset($response->response_code) ? $response->response_code : '' }}</td>
                            <td>{{ isset($response->success_message) ? $response->success_message : (isset($response->error_message) ? $response->error_message : '') }}</td>
                            <td>
                                <a href="{{ route('commissioner.sms.delete', $sms->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" >Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</section>

    
@endSection


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
            $("#example1").DataTable({

                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
               

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        });
    </script>

@endpush