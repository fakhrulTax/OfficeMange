@extends('app')

@section('title', 'Arrear')

@push('css')
    <!--  Datatable -->

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@php
    $assessment_year = config('settings.assessment_year_'.Auth::user()->circle);
    $monthRange = App\Helpers\MyHelper::dateRangeAssessmentYear($assessment_year);
    $circleData = App\Models\Tds_collection::getAssessmentYearCollectionByCircle($monthRange, [Auth::user()->circle]);
@endphp

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
               

            </div>
        </div>

    </div>



    <section class="content">

        <div class="container-fluid">

          
            <section class="content">


                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4>Total By Month</h4>
                        <table class="table table-bordered table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach ($monthRange as $month)
                                        <th>{{ $month }}</th>
                                    @endforeach
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Circle-{{ Auth::user()->circle }}</td>

                                    @php
                                        $circleTotal = 0;
                                    @endphp

                                    @foreach($monthRange as $month)
                                        <td>{{ App\Helpers\MyHelper::moneyFormatBD($circleData[Auth::user()->circle][$month]) }}</td>
                                        @php
                                            $circleTotal += $circleData[Auth::user()->circle][$month];
                                        @endphp
                                    @endforeach

                                    <td>{{ App\Helpers\MyHelper::moneyFormatBD($circleTotal) }}</td>
                                </tr>
                               
                            </tbody>
                            <tfoot>
                                <th colspan="3" class="text-center">Total</th>


                                <th></th>
                                <th class="text-right"> </th>
                                <th class="text-right"></th>

                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



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
        $(document).ready(function() {

            // change function for circle
            $('#circle').change(function() {
                let circle = $(this).val();

                $('#circle-form').submit();


            });



        });


        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({

                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

                    // Remove the formatting to get integer data for summation
                    let intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };

                    // Total over all pages
                    total = api
                        .column([3])
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);



                    // Total over this page
                    arrearTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);


                    // Update footer
                    api.column(3).footer().innerHTML = numberWithCommas(arrearTotal);


                    // Fine Total over this page
                    fineTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Update footer
                    api.column(4).footer().innerHTML = numberWithCommas(fineTotal);




                }

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        });
    </script>
@endpush
