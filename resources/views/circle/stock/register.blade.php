@extends('app')

@section('title', 'Stocks')

@push('css')
    <style>
        .address p {
            margin: 0;
        }
    </style>
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-4">
                    <h1 class="m-0">Stocks({{ $stockNumber }})</h1>
                </div>


                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary float-right" data-toggle=""
                            data-target=""><i class="fas fa-plus"></i>Print</button>
                    </ol>
                </div>

            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <!-- card heder -->
            <div class="card-header">

            <!-- /.card-header -->
            <div class="card-body">
                

            <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TIN, Name</th>

                    @foreach ($assessmentYears as $assYear)
                        <th>{{ $MyHelper::assessment_year_format($assYear) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $key => $stock)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            {{ $stock->tin }} <br>
                            {!!$MyHelper::formatToTwoLines(ucfirst($stock->name), 20) !!}
                        </td>

                        @foreach ($assessmentYears as $year)
                            <td>
                                @php
                                    $retarn = $stock->retarns->where('assessment_year', $year)->first();
                                @endphp
                                {{ $retarn ? $MyHelper::moneyFormatBD($retarn->income) : '' }} <br>
                                <span style="border-top: 1px solid black">
                                    {{ $retarn ? $MyHelper::moneyFormatBD($retarn->net_asset) : '' }} 
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
</table>

            



            </div>
            <!-- /.card-body -->

            <!-- card-footer -->
            <div class="card-footer">
                <ul class="pagination pagination-sm m-0 float-right">
                  {{ $stocks->links("pagination::bootstrap-4") }}
                </ul>
            </div>
            <!-- card-footer -->
        </div>
        <!-- /.card -->

    </section>



@endsection



@push('js')
    

@endpush
