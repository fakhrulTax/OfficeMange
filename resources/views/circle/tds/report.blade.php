@extends('app')



@section('title', 'TDS Report')



@push('css')

    <!--  Datatable -->



    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endpush



@php

    

    

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





                <div class="card card-primary" id="circle_table_wrapper">



                <div class="card-header">

                    Total TDS By Month

                </div>   

                    <!-- /.card-header -->

                    <div class="card-body">

                        

                        <table class="table table-bordered table-responsive table-striped" id="circle_table">

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

                                    <td>Circle-{{ $circle }}</td>



                                    @php

                                        $circleTotal = 0;

                                    @endphp



                                    @foreach($monthRange as $month)

                                    <td>{{ isset($circleData[$circle][$month]) ? App\Helpers\MyHelper::moneyFormatBD($circleData[$circle][$month]) : "" }}</td>

                                        @php

                                            $circleData ? $circleTotal += $circleData[$circle][$month] : '';

                                        @endphp

                                    @endforeach



                                    <td>{{ App\Helpers\MyHelper::moneyFormatBD($circleTotal) }}</td>

                                </tr>

                               

                            </tbody>

                        </table>

                    </div>

                    <!-- /.card-body -->

                </div>

                <!-- /.card -->



                <!-- card For Total TDS By Upazila -->

                <div class="card card-secondary" id="upazila_table_wrapper">



                <div class="card-header">

                    Total TDS By Upazila

                </div>   

                    <!-- /.card-header -->

                    <div class="card-body">

                        

                        <table class="table table-bordered table-responsive table-striped" id="upazila_table">

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



                                @php

                                    $totalAllMonths = 0;                                    

                                    $columnTotals = [];

                                @endphp



                                @foreach($upazilaData as $key => $upazilaD)

                                <tr>                                   



                                    @php                                    

                                        $upazila = App\Models\Upazila::find($key);

                                        $rowTotal = 0;

                                    @endphp



                                    @if( Auth::user()->user_role == 'circle' )

                                        <td><a href="{{ route('circle.tds.report.upzila.org', $upazila->id) }}">{{ $upazila->name }}</a></td>

                                    @elseif( Auth::user()->user_role == 'range' )

                                        <td><a href="{{ route('range.tds.report.circle.upazila', [$upazila->id, $circle]) }}">{{ $upazila->name }}</a></td>

                                    @elseif( Auth::user()->user_role == 'commissioner' )

                                        <td><a href="{{ route('commissioner.tds.report.circle.upazila', [$upazila->id, $circle]) }}">{{ $upazila->name }}</a></td>

                                    @endif



                                    @foreach($monthRange as $month)



                                        <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($upazilaD[$month]) }}</td>



                                        @php

                                            $rowTotal += $upazilaD[$month];

                                            $columnTotals[$month] = ($columnTotals[$month] ?? 0) + $upazilaD[$month];

                                            $totalAllMonths += $upazilaD[$month];

                                        @endphp



                                    @endforeach



                                    <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($rowTotal) }}</td>

                                </tr>

                                @endforeach

                               

                            </tbody>

                            <tfoot>

                                <th>Total</th>

                                @foreach ($monthRange as $month)

                                    <th class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month] ?? 0) }}</th>  

                                @endforeach

                                <th class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</th>

                            </tfoot>

                        </table>

                    </div>

                    <!-- /.card-body -->

                </div>

                <!-- /.card -->



                 <!-- card For Total TDS By Upazila -->

                 <div class="card card-danger" id="authority_table_wrapper">



                <div class="card-header">

                    Total TDS By Authority 

                </div>   

                    <!-- /.card-header -->

                    <div class="card-body">

                        

                        <table id="authority_table" class="table table-bordered table-responsive table-striped">

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



                                @php

                                    $totalAllMonths = 0;                                    

                                    $columnTotals = [];

                                @endphp



                                @foreach($orgDatas as $key => $orgData)

                                <tr>                                   



                                    @php                                    

                                        $org = App\Models\Organization::find($key);

                                        $rowTotal = 0;

                                    @endphp



                                    <td>{{ $org->name }}</td>



                                    @foreach($monthRange as $month)



                                        <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($orgData[$month]) }}</td>



                                        @php

                                            $rowTotal += $orgData[$month];

                                            $columnTotals[$month] = ($columnTotals[$month] ?? 0) + $orgData[$month];

                                            $totalAllMonths += $orgData[$month];

                                        @endphp



                                    @endforeach



                                    <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($rowTotal) }}</td>

                                </tr>

                                @endforeach

                            

                            </tbody>

                            <tfoot>

                                <th>Total</th>

                                @foreach ($monthRange as $month)

                                    <th class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month] ?? 0) }}</th>  

                                @endforeach

                                <th class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</th>

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

        $(function() {



            $("#authority_table").DataTable({

                "responsive": false,

                "lengthChange": true,

                "autoWidth": true,

                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                

            }).buttons().container().appendTo('#authority_table_wrapper .col-md-6:eq(0)');



            $("#upazila_table").DataTable({

                "responsive": false,

                "lengthChange": true,

                "autoWidth": true,

                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                

            }).buttons().container().appendTo('#upazila_table_wrapper .col-md-6:eq(0)');



            $("#circle_table").DataTable({

                "responsive": false,

                "lengthChange": true,

                "autoWidth": true,

                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                

            }).buttons().container().appendTo('#circle_table_wrapper .col-md-6:eq(0)');



        });

    </script>

@endpush

