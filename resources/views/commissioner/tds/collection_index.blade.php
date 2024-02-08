@extends('app')

@section('title', 'TDS')

@section('content')

@php
    $assessment_year = 20232024;
    $monthRange = App\Helpers\MyHelper::dateRangeAssessmentYear($assessmentYear = 20232024);
    
    $circleData = App\Models\Tds_collection::getAssessmentYearCollectionByCircle($monthRange);
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
                            <h5>Total Collection:  </h5>
                            <p>Govt: </p>
                            <p>Non Govt: </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                            <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                        <div class="inner">
                            <h5>Total Organization:  </h5>
                            <p>Govt: </p>
                            <p>Non Govt: </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                            <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                                            @foreach( $monthRange as $month )
                                                <th> {{ $month }} </th>
                                            @endforeach
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($circleData as $key => $circleMonth)
                                        <tr>
                                            <td>C-{{ $key }}</td>
                                            @foreach( $monthRange as $month )
                                                <td>{{ $circleMonth[$month] }}</td>
                                            @endforeach                                            
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <td>Total</td>
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
                                            <th>Distict</th>
                                            @foreach( $monthRange as $month )
                                                <th> {{ $month }} </th>
                                            @endforeach
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @for($i = 1; $i <= 6; $i++)
                                        <tr>
                                            <td> Cumilla </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endfor

                                        <tr>
                                            <td>Total</td>
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
