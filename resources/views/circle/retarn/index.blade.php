@extends('app')

@section('title','Return')

@push('css')
   
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-2">
                    <h1 class="m-0">Return</h1>
                </div>

                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                        Search
                    </button>
                </div>

                <div class="col-sm-2">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModa2">
                        Excel
                    </button>
                </div>

                <div class="col-sm-2">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModa3">
                        Register
                    </button>
                </div>

                <div class="col-sm-3">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('circle.return.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Return</a>
                    </ol>
                </div>

            </div>
        </div>

    </div>

    <section class="content">
        
        <div class="card">

             @if( count($retarns) < 1  )

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->
            <div class="card-body">
                
                 <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-secondary">
                        
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>TIN, Name, Ass. Year, Regiser & No, Date </th>
                            <th>Source of Income</th>
                            <th style="min-width: 120px">Income</th>
                            <th style="min-width: 120px">Tax</th>
                            <th style="min-width: 120px">Net Asset</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                        <tbody>
                            @php 
                                $i = 1; 
                                $sum173 = 0;
                                $sumSercharge = 0;
                                $sumS1 = 0;
                                $sumSP = 0;
                            @endphp

                            @foreach($retarns as $retarn)

                            <tr>
                                <td>{{ $i }}</td>

                                <td>
                                    {{ $retarn->tin }} <br>
                                    {{ $retarn->name }} <br>
                                    {{ $helper::assessment_year_format($retarn->assessment_year) }} <br>
                                    {{ ucfirst($retarn->register) }}-{{ $retarn->register_serial }} <br>
                                    {{ date('d-m-Y', strtotime($retarn->return_submission_date)) }}
                                </td>

                                <td>{{ $retarn->source_of_income }}</td>

                                <td>
                                    {{ $helper::moneyFormatBD($retarn->income) }} <br>
                                    @if($retarn->income_of_poultry_fisheries)
                                        P.Fish: {{ $helper::moneyFormatBD($retarn->income_of_poultry_fisheries) }} <br>
                                    @endif

                                    @if($retarn->income_of_remittance)
                                        Rem: {{ $helper::moneyFormatBD($retarn->income_of_remittance) }}
                                    @endif
                                </td>

                                <td>
                                    173: {{ $helper::moneyFormatBD($retarn->retarn_tax) }} <br>

                                    @if($retarn->source_tax)
                                        AIT: {{ $helper::moneyFormatBD($retarn->source_tax) }} <br> 
                                    @endif
                                    
                                    @if($retarn->advance_tax)
                                        Adv: {{ $helper::moneyFormatBD($retarn->advance_tax) }} <br>
                                    @endif

                                    @if($retarn->late_fee)
                                        173: {{ $helper::moneyFormatBD($retarn->late_fee) }} <br>
                                    @endif

                                    @if($retarn->sercharge)
                                        Ser: {{ $helper::moneyFormatBD($retarn->sercharge) }} <br>
                                    @endif

                                    @if($retarn->tax_of_schedule_one)
                                        S1 : {{ $helper::moneyFormatBD($retarn->tax_of_schedule_one) }} <br>
                                    @endif

                                    @if($retarn->special_tax)
                                        SP : {{ $helper::moneyFormatBD($retarn->special_tax) }} <br>
                                    @endif

                                    @if($retarn->total_tax > $retarn->retarn_tax)
                                        <span style="border-top: 1px solid #000">Total: {{ $helper::moneyFormatBD($retarn->total_tax) }}</span> 
                                    @endif
                                </td>

                                <td>{{ $helper::moneyFormatBD($retarn->net_asset) }}</td>
                                <td>{{ $retarn->comments }}</td>
                                <td>
                                    <a href="{{ route('circle.return.edit', $retarn) }}" class="btn btn-warning btn-sm mt-1">Edit</a> <br>
                                    <a href="{{ route('circle.retarn.orderSheet', $retarn) }}" target="_blank" class="btn btn-danger btn-sm mt-1">Order</a>
                                </td>
                            </tr>

                            @php 
                                $i++; 
                                $sum173 = $sum173 + $retarn->retarn_tax;
                                $sumSercharge = $sumSercharge + $retarn->sercharge;
                                $sumS1 = $sumS1 + $retarn->tax_of_schedule_one;
                                $sumSP = $sumSP + $retarn->special_tax;
                            @endphp
                            
                            @endforeach
                            <!-- Repeat rows as needed -->
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan = 4>Total Tax</th>
                                <th colspan = 4>
                                    173 : {{ $helper::moneyFormatBD($sum173) }} <br>
                                    Ser : {{ $helper::moneyFormatBD($sumSercharge) }} <br>
                                    S1  : {{ $helper::moneyFormatBD($sumS1) }} <br>
                                    SP  : {{ $helper::moneyFormatBD($sumSP) }}
                                </th>
                            </tr>
                        </tfoot>


                    </table>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <ul class="pagination pagination-sm m-0 float-right">
                {{ $retarns->links('pagination::bootstrap-4') }}
              </ul>
            </div>

            @endif

        </div>
        <!-- /.card -->

    </section>



<!-- Filter Modal -->
@include('circle.retarn.modal.filter')
@include('circle.retarn.modal.excel')

    
@endsection



@push('js')
    <script>     



    </script>
@endpush