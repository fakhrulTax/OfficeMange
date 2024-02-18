@extends('app')

@section('title', $title)

@section('content')


    @php
        $assessment_year = config('settings.assessment_year_commissioner');
        $monthRange = App\Helpers\MyHelper::dateRangeAssessmentYear($assessment_year);
        $upazilasData = App\Models\Tds_collection::getAssessmentYearCollectionByUpazila($upazilaIds, $monthRange);
    @endphp


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TDS Collection( {{ $zilla->name }} )</h1>
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
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">Upazila TDS</div>
                            <div class="card-body">
                            <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Upazila</th>
                                    @foreach ($monthRange as $month)
                                        <th>{{ $month }}</th>
                                    @endforeach
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $totalAllMonths = 0;
                                    $rowTotal = 0;
                                    $columnTotals = [];
                                @endphp

                                @foreach ($upazilasData as $key => $upazilaData)
                                    @php                             
                                        
                                        if (!count($upazilasData)) {
                                            continue;
                                        } 
                                        $upazila = App\Models\Upazila::find($key);                                 
                                        
                                    @endphp

                                    <tr>
                                        <td>{{ ucfirst($upazila->name) }}</td>
                                        @foreach ($monthRange as $month)
                                            <td>{{ App\Helpers\MyHelper::moneyFormatBD($upazilaData[$month]) }}</td>
                                            @php
                                                $rowTotal += $upazilaData[$month];
                                                $columnTotals[$month] = ($columnTotals[$month] ?? 0) + $upazilaData[$month];
                                                $totalAllMonths += $upazilaData[$month];
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