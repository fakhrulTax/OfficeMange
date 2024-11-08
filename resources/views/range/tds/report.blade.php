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
                <div class="col-sm-6">
                    <h1 class="m-0">TDS Collection</h1>
                </div>

                <div class="col-md-6">

                    <form class="form-inline" action="{{ route('range.tds.year') }}" method="GET">
                    @csrf
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="assessment_year" class="sr-only">Assessment Year</label>
                            <select name="assessment_year" id="assessment_year" class="form-control">
                            <option value="{{ $assessment_year }}" 
                                {{ $search_assessment_year == $assessment_year ? 'selected' : '' }}>
                                {{ App\Helpers\MyHelper::assessment_year_format($assessment_year) }}
                            </option>
                                <option value="{{ $assessment_year - 10001 }}" {{ isset($search_assessment_year) && $search_assessment_year == ($assessment_year - 10001)  ? 'selected' : '' }}> {{ App\Helpers\MyHelper::assessment_year_format($assessment_year - 10001) }}</option>
                                <option value="{{ $assessment_year - 20002 }}" {{ isset($search_assessment_year) && $search_assessment_year == ($assessment_year - 20002) ? 'selected' : '' }}> {{ App\Helpers\MyHelper::assessment_year_format($assessment_year - 20002) }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Submit</button>

                    </form>

                </div>

            </div>

        </div>



    </div>







    <section class="content">



        <div class="container-fluid">



          

            <section class="content">





                <div class="card card-primary" id="circle_table_wrapper">



                <div class="card-header">

                    Total TDS By Circle

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

                                @foreach($circleDatas as $key => $circleData)

                                    <tr>

                                        <td><a href="{{ Route('range.tds.report.circle', $key) }}">Circle-{{ $key }}</a></td>



                                        @php

                                            $totalRow = 0; 

                                        @endphp



                                        @foreach ($monthRange as $month)

                                            <td>{{ App\Helpers\MyHelper::moneyFormatBD( $circleData[$month] ) }}</td>

                                            @php

                                                $totalRow += $circleData[$month]; // Update row total

                                            @endphp

                                        @endforeach



                                        <td>{{ App\Helpers\MyHelper::moneyFormatBD($totalRow) }}</td>

                                    </tr>

                                @endforeach

                            </tbody>



                            <tfoot>

                                <tr>

                                    <th>Total</th>



                                    @php

                                        $totals = array_fill_keys($monthRange, 0); // Initialize column totals

                                    @endphp



                                    @foreach($circleDatas as $circleData)

                                        @foreach ($monthRange as $month)

                                            @php

                                                $totals[$month] += $circleData[$month]; // Update column total

                                            @endphp

                                        @endforeach

                                    @endforeach



                                    @foreach ($monthRange as $month)

                                        <th>{{ App\Helpers\MyHelper::moneyFormatBD( $totals[$month] ) }}</th>

                                    @endforeach



                                    <th>{{ App\Helpers\MyHelper::moneyFormatBD( array_sum($totals) ) }}</th>

                                </tr>

                            </tfoot>

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



                                    <td><a href="{{ route('range.tds.report.upazila', $upazila->id) }}">{{ $upazila->name }}</a></td>



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



                 <!-- card For Total TDS By Organization -->

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