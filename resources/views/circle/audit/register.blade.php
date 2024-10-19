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
                <h1 class="m-0">Audit Register <span class="text-success">(Circle-{{ $circle }})</span></h1>
            </div>

        </div>
    </div>
</div>

<section class="content">

    <div class="card">
        @if (count($audits) < 1)
            <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
        @else
            <div class="card-body">
                <table id="example1" class="table table-primary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIN, Name & Address</th>
                            <th>Assessment Year</th>
                            <th>Audit Date</th>
                            <th>Main Income & Tax</th>
                            <th>Exp. Date</th>
                            <th>Disposal Date</th>
                            <th>Ass. Income & Tax</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($audits as $key => $audit)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    {{ $audit->tin }} <br>
                                    {{ $audit->stock->name }} <br>
                                    {{ $audit->stock->bangla_name }} <br>
                                    <div class="address">
                                        {!! $audit->stock->address !!}
                                    </div>
                                    @if($audit->stock->mobile)
                                        মোবাইল : {{ $audit->stock->mobile }}
                                    @endif
                                </td>
                                <td>{{ App\Helpers\MyHelper::assessment_year_format($audit->assessment_year) }}</td>
                                <td>{{ \Carbon\Carbon::parse($audit->audit_date)->format('d-m-Y') }}</td>
                                <td>
                                    {{ App\Helpers\MyHelper::moneyFormatBD($audit->main_income) }} <br>
                                    <span style="border-top: 1px solid black">
                                        {{ App\Helpers\MyHelper::moneyFormatBD($audit->main_tax) }}
                                    </span>
                                </td>
                                <td>{{ $audit->expire_date ? \Carbon\Carbon::parse($audit->expire_date)->format('d-m-Y') : '' }}</td>
                                <td>{{ $audit->disposal_date ? \Carbon\Carbon::parse($audit->disposal_date)->format('d-m-Y') : '' }}</td>
                                <td>
                                    {{ $audit->assessed_income ? App\Helpers\MyHelper::moneyFormatBD($audit->assessed_income) : '' }} <br>
                                    <span style="border-top: 1px solid black">
                                        {{ $audit->demand ? App\Helpers\MyHelper::moneyFormatBD($audit->demand) : '' }}
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
