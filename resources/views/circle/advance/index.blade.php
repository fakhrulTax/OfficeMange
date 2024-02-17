@extends('app')
@section('title', $title)
@push('css')
   <style>
        .address p{
            margin-bottom: 0;
        }
   </style>
@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Advance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->user_role == 'circle')
                        <a href="{{ route('circle.advance.create') }}" class="btn btn-primary float-right"><i
                                class="fas fa-plus"></i> Add Advance</a>
                        @endif
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">
            <div class="card-body">
                @if( Auth::user()->user_role == 'circle' )
                <form action="{{ route('circle.advance.search') }}" method="GET">
                @elseif( Auth::user()->user_role == 'commissioner' )
                <form action="{{ route('commissioner.advance.search') }}" method="GET">
                @endif
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="number" id="tin" name="tin" placeholder="TIN" class="form-control"value="{{ Request::get('tin') }}" autofocus>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="number" id="advance_assessment_year" name="advance_assessment_year"
                                    placeholder="Advance Assessment Year" class="form-control"
                                    value="{{ Request::get('advance_assessment_year') }}">
                            </div>
                        </div>
                        
                        @if( Auth::user()->user_role != 'circle' )
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="circle" id="circle" class="form-control">
                                    <option value="">Select Circle</option>
                                    <option value="range-1" {{ (Request::get('circle') == 'range-1') ? 'selected' : '' }}>Range-1</option>
                                    <option value="range-2" {{ (Request::get('circle') == 'range-2') ? 'selected' : '' }}>Range-2</option>
                                    <option value="range-3" {{ (Request::get('circle') == 'range-3') ? 'selected' : '' }}>Range-3</option>
                                    <option value="range-4" {{ (Request::get('circle') == 'range-4') ? 'selected' : '' }}>Range-4</option>                                    
                                    @for($i = 1; $i<=22; $i++)
                                        <option value="{{ $i }}"  {{ (Request::get('circle') == $i) ? 'selected' : '' }}>Circle-{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

        <div class="card">

            @if (count($advances) < 1)

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    @if( Auth::user()->user_role == 'circle' )
                        <a href="{{ Route('circle.advance.register') }}" class="btn btn-sm btn-primary" target="_blank">Register</a>
                    @endif
                    <table id="example1" class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Assessment Year</th>
                                <th>TIN, Name & Address</th>
                                <th>Last Return Information</th>
                                <th>Collection From Advance</th>
                                @if(Auth::user()->user_role == 'circle')
                                    <th>Action</th>
                                @else
                                    <th>Circle</th> 
                                @endif
                            </tr>
                        </thead>

                        <tbody>


                            @foreach ($advances as $key => $advance)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td> {{ App\Helpers\MyHelper::assessment_year_format($advance->advance_assessment_year) }}
                                    </td>
                                    <td>
                                        {{ $advance->tin }} <br>
                                        {{ $advance->stock->name }} <br>
                                        {{ $advance->stock->bangla_name }} <br>
                                        <div class="address">
                                            {!! $advance->stock->address !!}
                                        </div>
                                        @if( $advance->stock->mobile  )
                                            মোবাইল : {{ $advance->stock->mobile }}
                                        @endif
                                    </td>

                                    <td>
                                        Last Return : {{ App\Helpers\MyHelper::assessment_year_format($advance->return_submitted_assessment_year) }} <br>
                                        Income: {{ App\Helpers\MyHelper::moneyFormatBD($advance->income) }} <br>
                                        Tax: {{ App\Helpers\MyHelper::moneyFormatBD($advance->tax) }}                                        
                                    </td>
                                    <td>
                                        @php
                                            $advaneCollections = App\Models\Collection::getAdvanceByAssessmentYear($advance->tin, $advance->advance_assessment_year);
                                            $totalAmount = 0;
                                        @endphp
                                        
                                        @if(count($advaneCollections) > 0)
                                            @foreach($advaneCollections as $advanceCollection)
                                            @php
                                                $totalAmount += $advanceCollection->amount;
                                            @endphp
                                            <p>
                                                {{ date('d-m-Y', strtotime($advanceCollection->pay_date)) }} : 
                                                {{ App\Helpers\MyHelper::moneyFormatBD($advanceCollection->amount) }}                                               
                                            </p>                                            
                                            @endforeach
                                            <p style="border-top: 1px solid #000">
                                                Total: {{ App\Helpers\MyHelper::moneyFormatBD($totalAmount) }}
                                            </p>
                                        @endif
                                    </td>
                                    @if(Auth::user()->user_role == 'circle')
                                    <td>
                                        <a href="{{ route('circle.advance.edit', $advance->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <button class="btn btn-sm btn-success" onclick="advanceModal({{ $advance->tin }}, {{ $advance->advance_assessment_year }})">Notice</button>                                        
                                    </td>
                                    @else
                                        <td>{{ $advance->circle }}</td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $advances->links('pagination::bootstrap-4') }}
                    </ul>
                </div>

            @endif

        </div>


<div class="modal fade" id="advanceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advance Notice </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('circle.advance.notice') }}" method="POST" target="_blank" >
          @csrf
          <input type="hidden" id="advanceTIN" name="advanceTIN">
          <input type="hidden" id="noticeYear" name="noticeYear">
          <div class="form-group">
            <label for="premimum">Notice Premium</label>
            <select name="premimum" id="premimum" class="form-control">
              <option value="1">1st</option>
              <option value="2">2nd</option>
              <option value="3">3rd</option>
              <option value="4">4th</option>
            </select>
          </div> 
          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            @error('issue_date')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy">
          </div>    
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Print</button>
        </div>
      </form>
    </div>
  </div>
</div>

    </section>


@endsection

@push('js')
  <script>
    function advanceModal(tin, assessment_year)
    {
      document.getElementById('advanceTIN').value = tin;
      document.getElementById('noticeYear').value = assessment_year;
      $('#advanceModal').modal('toggle');
    }
  </script>
  @endpush
