@extends('app')

@section('title', 'TDS')

@section('content')


    @php
        $assessment_year = 20232024;
        $monthRange = App\Helpers\MyHelper::dateRangeAssessmentYear($assessmentYear = 20232024);

        $circleData = App\Models\Tds_collection::getAssessmentYearCollectionByCircle($monthRange);

       $zillas = App\Models\Zilla::orderBy('name')->get();

    @endphp


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TDS Collection</h1>
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
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h5>Total Collection: </h5>
                                <p>Govt: </p>
                                <p>Non Govt: </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h5>Total Organization: </h5>
                                <p>Govt: </p>
                                <p>Non Govt: </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">Circle Wise Collection</div>
                            <div class="card-body">
                            <table class="table table-bordered table-responsive">
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
                                            <td>C-{{ $key }}</td>
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

                                    <tr>
                                        <td>Total</td>
                                        @php
                                            $totalAllMonths = 0;
                                        @endphp
                                        @foreach($monthRange as $month)
                                            <td>{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month]) }}</td>
                                            @php
                                                $totalAllMonths += $columnTotals[$month];
                                            @endphp

                                        @endforeach
                                        <td>{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">Distict Wise Collection</div>
                            <div class="card-body">
                            <table class="table table-bordered table-responsive">
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
                                        $columnTotals = [];
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

                                <tr>
                                    <td>Total</td>
                                    @foreach ($monthRange as $month)
                                        <td>{{ App\Helpers\MyHelper::moneyFormatBD($columnTotals[$month] ?? 0) }}</td>  
                                    @endforeach
                                    <td>{{ App\Helpers\MyHelper::moneyFormatBD($totalAllMonths) }}</td>
                                </tr>
                            </tbody>
                        </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </section>




@endsection

@push('js')
@endpush