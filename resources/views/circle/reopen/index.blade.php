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
            <div class="col-sm-4">
                <h1 class="m-0">Reopen <span class="text-success">(Circle-{{ $circle }})</span></h1>
            </div>

            <div class="col-sm-4">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModa1">
                    Register
                </button>
            </div>

            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    @if(Auth::user()->user_role == 'circle')
                        <a href="{{ route('circle.reopen.create') }}" class="btn btn-primary float-right">
                            <i class="fas fa-plus"></i> Add Reopen
                        </a>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="card">
        <div class="card-body">
            @if(Auth::user()->user_role == 'circle')
                <form action="{{ route('circle.reopen.search') }}" method="GET">
            @elseif(Auth::user()->user_role == 'commissioner')
                <form action="" method="GET">                         
            @elseif(Auth::user()->user_role == 'range')
                <form action="" method="GET">
            @endif

            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" id="tin" name="tin" placeholder="TIN" class="form-control" value="{{ Request::get('tin') }}" autofocus>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" id="assessment_year" name="assessment_year" placeholder="Assessment Year" class="form-control" value="{{ Request::get('assessment_year') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" id="expire_date" name="expire_date" placeholder="Expire Date" class="form-control" value="{{ Request::get('expire_date') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <select name="disposal" id="disposal" class="form-control">
                            <option value="">Disposed?</option>
                            <option value="1" {{ Request::get('disposal') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ Request::get('disposal') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>                      

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>

            </form>
        </div>
    </div>

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
                            @if(Auth::user()->user_role == 'circle')
                                <th>Action</th>
                            @else
                                <th>Circle</th> 
                            @endif
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
                                @if(Auth::user()->user_role == 'circle')
                                    <td>
                                        <a href="{{ route('circle.reopen.edit', $reopen) }}" class="btn btn-sm btn-danger">Update</a>
                                    </td>
                                @else
                                    <td>{{ $reopen->circle }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <!-- Add footer content here if necessary -->
                    </tfoot>
                </table>
            </div>

            <div class="card-footer">
                <ul class="pagination pagination-sm m-0 float-right">
                    {{ $reopens->links('pagination::bootstrap-4') }}
                </ul>
            </div>
        @endif
    </div>
</section>


       <!-- Modal -->
       <div class="modal fade" id="exampleModa1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">

       <form action="{{ route('circle.reopen.register') }}" method="GET" target="_balnk">
        @csrf
        <div class="modal-content">

            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">                   
                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="assessment_year" placeholder="20242025" required>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>                

            </div>
        </form>

        </div>
    </div>
@endsection

@push('js')
@endpush
