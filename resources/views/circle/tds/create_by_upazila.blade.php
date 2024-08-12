@extends('app')
@section('title', 'TDS Create')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add New TDS <span class="text-success"> ( {{ ucfirst($selectedUpazila->name) }} )</span></h1>
            </div>

            <div class="col-md-6">
            </div>

        </div>
    </div>

</div>

<div class="card">
    <div class="card-body">

     
        <form action="{{ route('circle.tds.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="zilla">Zilla</label>
                        <select class="form-control" id="zilla" name="zilla_id" required>
                                <option value="{{ $selectedDistict->id }}">{{ ucfirst($selectedDistict->name) }}</option>


                        </select>

                        @error('zilla_id')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            
                        @enderror

                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="upazila">Upazilla</label>
                        <select class="form-control" name="upazila_id" id="upazila" required>
                                <option value="{{ $selectedUpazila->id }}">{{ ucfirst($selectedUpazila->name) }}</option>
                        </select>
                        @error('upazila_id')
                        <span class="text-danger" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                            
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="organization">Organization</label>
                        <select class="form-control" name="organization_id" id="organization" required autofocus>
                            <option value="">Select Organization</option>

                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ ucfirst($organization->name) }}</option>
                            @endforeach

                        </select>

                        @error('organization_id')
                        <span class="text-danger" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                            
                        @enderror
                    </div>
                </div>




                <div class="col-md-2">

                    <div class="form-group">
                        <label for="collection_month">Collection Month</label>
                        <input type="text" id="collection_month" name="collection_month" 
                            placeholder="01-2024" class="form-control" value="{{ old('collection_month') }}" required  autocomplete="off">

                            @error('collection_month')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tds">TDS</label>
                        <input type="number" id="tds" name="tds" placeholder="TDS" class="form-control">
                            @error('tds')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>

                <div class="col-md-3">

                    <div class="form-group">
                        <label for="bill">Bill</label>
                        <input type="number" id="bill" name="bill" placeholder="bill" class="form-control" value="{{ old('bill') }}">

                            @error('bill')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>



              

                <div class="col-md-3">
                    <label for="comments">Comment</label>
                    <div class="form-group">
             <textarea name="comments" id="" cols="30" rows="1" class="form-control">{{old('comments')}}</textarea>
                    </div>

                    @error('comments')
                    <span class="text-danger" role="alert">
                        <strong> {{ $message }}</strong>
                    </span>
                        
                    @enderror
                </div>

                <div class="col-md-2 mt-4">
                    <input type="submit" value="Add TDS" class="btn btn-primary mt-2">

                </div>

            </div>

        </form>
   
    </div>
</div>

<div class="card">


            @if (count($tdses) < 1)


                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="movement_table" class="table  table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Collection Month </th>
                                <th>Zilla</th>
                                <th>Upazila</th>
                                <th>Orginization</th>
                                <th>TDS</th>

                                <th>Bill</th>                                

                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @php
                                $totalTDS = 0;
                            @endphp

                            @foreach ($tdses as $key => $tds)

                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        {{ date('M-Y', strtotime($tds->collection_month)) }}<br>

                                    </td>
                                    <td> {{ ucfirst($tds->upazila->zilla->name ) }}</td>
                                    <td> {{ ucfirst($tds->upazila->name) }}</td>
                                    <td> {{ ucfirst($tds->organization->name )}} </td>
                                    <td>
                                        {{ App\Helpers\MyHelper::moneyFormatBD($tds->tds) }}
                                    </td>
                                    <td> {{ App\Helpers\MyHelper::moneyFormatBD($tds->bill) }} </td>
                                    
                                    <td> {{ $tds->comments }} </td>
                                    <td> 
                                      <a href="{{ route('circle.tds.edit', [$tds->id, 'clicked_route' => Route::currentRouteName()]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>

                                </tr>
                                @php
                                    $totalTDS += $tds->tds;
                                @endphp

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="font-weight-bold text-center">Total</td>

                                <td>{{ App\Helpers\MyHelper::moneyFormatBD($totalTDS ) }}</td>

                                <td colspan="2"></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
             

            @endif

        </div>
        <!-- /.card -->

   <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">

            {{ $tdses->links("pagination::bootstrap-4") }}

        </ul>
    </div>



@endsection


@push('js')


    
@endpush