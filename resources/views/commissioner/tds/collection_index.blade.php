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
                    <h1 class="m-0">TDS Collection</h1>
                </div>

                <div class="col-md-6">

                    <form class="form-inline" action="{{ route('commissioner.tds.year') }}" method="GET">
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


        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h4>Total TDS: {{ App\Helpers\MyHelper::moneyFormatBD($toatalGovtTDS + $toatalNonGovtTDS) }}</h4>
                                <h6>Govt TDS: {{ App\Helpers\MyHelper::moneyFormatBD($toatalGovtTDS) }}</h6>
                                <h6>Non Govt TDS: {{ App\Helpers\MyHelper::moneyFormatBD($toatalNonGovtTDS) }}</h6>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ Route('commissioner.tdsList.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h4>Total Organization: {{ $govtOrgNumber + $nonGovtOrgNumber }}</h4>
                                <h6>Govt: {{ $govtOrgNumber }}</h6>
                                <h6>Non Govt: {{ $nonGovtOrgNumber }}</h6>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ Route('commissioner.tds.organization.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" id="circle_table_wrapper">
                            <div class="card-header">Circle Wise TDS Collection</div>
                            <div class="card-body">
                            <table class="table table-bordered table-responsive" id="circle_table">
                                <thead>
                                    <tr>
                                        <th>Circle</th>
                                        @foreach($monthRange as $month)
                                            <th>{{ $month }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $columnTotals = array_fill_keys($monthRange, 0);
                                    @endphp

                                    @foreach($circleData as $key => $circleMonth)
                                        <tr>
                                            <td><a href="{{ route('commissioner.tds.report.circle', $key) }}">Circle-{{ $key }}</a></td>
                                            @php
                                                $rowTotal = 0;
                                            @endphp
                                            @foreach($monthRange as $month)
                                                <td>{{ App\Helpers\MyHelper::moneyFormatBD($circleMonth[$month]) }}</td>
                                                @php
                                                    $rowTotal += $circleMonth[$month];
                                                    $columnTotals[$month] += $circleMonth[$month];
                                                @endphp
                                            @endforeach
                                            <td>{{ App\Helpers\MyHelper::moneyFormatBD($rowTotal) }}</td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                            @php
                                                $totalAllMonths = 0;
                                            @endphp
                                            @foreach($monthRange as $month)
                                                <th>{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month]) }}</th>
                                                @php
                                                    $totalAllMonths += $columnTotals[$month];
                                                @endphp

                                            @endforeach
                                            <th>{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-primary" id="distict_table_wrapper">
                            <div class="card-header">Distict Wise TDS Collection</div>
                            <div class="card-body">
                                <table class="table table-bordered table-responsive" id="distict_table">
                                    <thead>
                                        <tr>
                                            <th>District</th>
                                            @foreach ($monthRange as $month)
                                                <th>{{ $month }}</th>
                                            @endforeach
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $totalAllMonths = 0;
                                            $columnTotals = []; // Initialize columnTotals outside the loop
                                        @endphp

                                        @foreach ($zillas as $zilla)
                                            @php 
                                                $ziallInstance = App\Models\Zilla::find($zilla->id);
                                                $upazilas = $ziallInstance->upazilas;    
                                                $upazilaIds = $upazilas->pluck('id')->toArray();                                   
                                                $zillaData = App\Models\Tds_collection::getAssessmentYearCollectionByZilla($upazilaIds, $monthRange);   
                                                if (!count($zillaData)) {
                                                    continue;
                                                } 
                                                $rowTotal = 0;
                                            @endphp

                                            <tr>
                                                <td><a href="{{ route('commissioner.tds.collection.zilla', $zilla->id) }}">{{ ucfirst($zilla->name) }}</a></td>

                                                @foreach ($monthRange as $month)
                                                    <td>{{ App\Helpers\MyHelper::moneyFormatBD($zillaData[$month]) }}</td>
                                                    @php
                                                        $rowTotal += $zillaData[$month];
                                                        $columnTotals[$month] = ($columnTotals[$month] ?? 0) + $zillaData[$month];
                                                        $totalAllMonths += $zillaData[$month];
                                                    @endphp
                                                @endforeach   
                                                <td>{{ App\Helpers\MyHelper::moneyFormatBD($rowTotal) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>                                
                                        <tr>
                                            <th>Total</th>
                                            @foreach ($monthRange as $month)
                                                <th>{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month] ?? 0) }}</th>  
                                            @endforeach
                                            <th>{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            </div>
                        
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
                                    <th>Authority</th>
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
                paging: false,
                ordering: false,                
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