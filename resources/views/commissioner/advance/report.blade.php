@extends('app')

@section('title', 'TDS')

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
                    <h1 class="m-0">Advance Report</h1>
                </div>

                <div class="col-md-6">

                </div>

            </div>
        </div>

    </div>

    <section class="content">



        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Tax Payers</span>
                                <span class="info-box-number">{{ App\Helpers\MyHelper::moneyFormatBD($totalAdvanceTaxPayers) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="info-box bg-gradient-danger">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Advance Tax Paid Tax Payers</span>
                                <span class="info-box-number">{{ App\Helpers\MyHelper::moneyFormatBD($totalAdvanceTaxPaidTaxPayers) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                       <!-- small box -->
                       <div class="info-box bg-gradient-warning">
                            <span class="info-box-icon"><i class="fab fa-speakap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Advance Collection</span>
                                <span class="info-box-number">{{ App\Helpers\MyHelper::moneyFormatBD($totalAdvanceCollection) }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" id="circle_table_wrapper">
                            <div class="card-header">Circle Wise Advance</div>
                            <div class="card-body">

                                <table class="table table-striped table-success table-bordered">
                                    <thead>
                                        <tr>
                                        <th scope="col">Circle</th>
                                        <th scope="col">Advance Tax Payers</th>
                                        <th scope="col">Advance Paid Tax Payers</th>
                                        <th scope="col">Advance Collection</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td class="text-right">@mdo</td>
                                        </tr>
                                        <tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


                    </div>
                </div>

            </div>
        </div>


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

            $("#circle_table").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                
            }).buttons().container().appendTo('#circle_table_wrapper .col-md-6:eq(0)');
            
            $("#distict_table").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                
            }).buttons().container().appendTo('#distict_table_wrapper .col-md-6:eq(0)');

            $("#authority_table").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                
            }).buttons().container().appendTo('#authority_table_wrapper .col-md-6:eq(0)');
            

        });
    </script>
@endpush