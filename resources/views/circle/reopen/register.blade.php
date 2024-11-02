@extends('app')

@section('title', $title)

@push('css')
<style>
    .address p {
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Reopen Register <span class="text-success">(Circle-{{ $circle }})</span></h1>
            </div>

        </div>
    </div>
</div>

<section class="content">

    <div class="card">
        @if (count($reopens) < 1)
            <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
        @else
            <div class="card-body">
                <table id="example1" class="table table-primary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIN, Name & Address</th>
                            <th>Assessment Year</th>
                            <th>Reopen Date</th>
                            <th>Main Income & Tax</th>
                            <th>Exp. Date</th>
                            <th>Disposal Date</th>
                            <th>Ass. Income & Tax</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reopens as $key => $reopen)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    {{ $reopen->tin }} <br>
                                    {{ $reopen->stock->name }} <br>
                                    {{ $reopen->stock->bangla_name }} <br>
                                    <div class="address">
                                        {!! $reopen->stock->address !!}
                                    </div>
                                    @if($reopen->stock->mobile)
                                        মোবাইল : {{ $reopen->stock->mobile }}
                                    @endif
                                </td>
                                <td>{{ App\Helpers\MyHelper::assessment_year_format($reopen->assessment_year) }}</td>
                                <td>{{ \Carbon\Carbon::parse($reopen->reopen_date)->format('d-m-Y') }}</td>
                                <td>
                                    {{ App\Helpers\MyHelper::moneyFormatBD($reopen->main_income) }} <br>
                                    <span style="border-top: 1px solid black">
                                        {{ App\Helpers\MyHelper::moneyFormatBD($reopen->main_tax) }}
                                    </span>
                                </td>
                                <td>{{ $reopen->expire_date ? \Carbon\Carbon::parse($reopen->expire_date)->format('d-m-Y') : '' }}</td>
                                <td>{{ $reopen->disposal_date ? \Carbon\Carbon::parse($reopen->disposal_date)->format('d-m-Y') : '' }}</td>
                                <td>
                                    {{ $reopen->assessed_income ? App\Helpers\MyHelper::moneyFormatBD($reopen->assessed_income) : '' }} <br>
                                    <span style="border-top: 1px solid black">
                                        {{ $reopen->demand ? App\Helpers\MyHelper::moneyFormatBD($reopen->demand) : '' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <!-- Add footer content here if necessary -->
                    </tfoot>
                </table>
            </div>

        @endif
    </div>
</section>


@endsection

@push('js')
@endpush
