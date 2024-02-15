@extends('app')

@section('title', 'TDS')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TDS</h1>
                </div>

                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('circle.tds.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add New TDS</a>
                    </ol>
                </div>

            </div>
        </div>

    </div>

    <section class="content">
        


        <div class="card">
            <div class="card-body">
              <form action="{{ route('circle.tds.search') }}" method="GET">
                <div class="row">
          
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="zilla">Zilla</label>
                            <select class="form-control" name="zilla_search" id="zilla_search">
                                <option value="">Select Zilla</option>
                                @foreach ($zillas as $zilla)
                                    <option value="{{ $zilla->id }}" {{ Request::get('zilla_search') == $zilla->id ? 'selected' : ''}} >{{ ucfirst($zilla->name) }} </option>
                                @endforeach
          
                            </select>
                        </div>
                    </div>
          
          
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="upazila_search">Upazilla</label>
                            <select class="form-control" name="upazila_search" id="upazila_search">
                                <option value="">Select Upazilla</option>

                                @if (Request::get('zilla_search'))

                                @php
                                    $uapzilas = App\Models\Upazila::where('zilla_id', Request::get('zilla_search'))->get();
                                @endphp
                                
                                @foreach ($uapzilas as $uapzila )
                                <option value="{{ $uapzila->id }}" {{ Request::get('upazila_search') == $uapzila->id ? 'selected' : ''}} > {{ ucfirst($uapzila->name)}} </option>
                                @endforeach
                                    
                                @endif
          
                            </select>
                        </div>
                    </div>
          
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="organization_search">Organization</label>
                            <select class="form-control" name="organization_search" id="organization_search" >
                                <option value="">Select Organization</option>
                                @if (Request::get('upazila_search'))

                                @php
                                    $organizations = App\Models\Upazila::where('id', Request::get('upazila_search'))->first()->organizations;
                                    
                                @endphp

                                @foreach ($organizations as $organization )
                                <option value="{{ $organization->id }}" {{ Request::get('organization_search') == $organization->id ? 'selected' : ''}} > {{ ucfirst($organization->name) }} </option>
                                @endforeach
                                    
                                @endif
                               
          
          
                            </select>

                          
                        </div>
                    </div>
          
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_month">Start Month</label>
                            <input type="month" name="start_month" value="{{ Request::get('start_month') }}" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_month">End Month</label>
                            <input type="month" name="end_month" value="{{ Request::get('end_month') }}" class="form-control">

                        </div>
                    </div>
          
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
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
                                      <a href="{{ route('circle.tds.edit', $tds->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                      <a href="{{ route('circle.tds.destroy', $tds->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this TDS?')">Delete</a>
                                    
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



    </section>




@endsection

@push('js')
    <script>
       

        $('#zilla_search').change(function() {
            var zilla = $(this).val();
            $('#upazila_search').empty();
            $('#organization_search').empty();
            if (zilla) {
             
                $.ajax({
                    type: "GET",
                    url: "{{ url('upazilla') }}/" + zilla,
                    dataType: "json",

                    success: function(res) {
                        if (res) {
                            


                            $('#upazila_search').append('<option value="">Select Upazilla</option>');
                            $.each(res.upazilla, function(key, value) {
                                $('#upazila_search').append('<option value="' + value.id + '">' + value
                                    .name + '</option>').css("text-transform", "capitalize");
                            });

                        }
                    }



                });
            }


        });

        $('#upazila_search').change(function() {
            var upazila = $(this).val();
            $('#organization_search').empty();
            if (upazila) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ogranization') }}/" + upazila,
                    dataType: "json",

                    success: function(res) {
                        if (res) {

                            

                            $('#organization_search').append('<option value="">Select Organization</option>');
                            $.each(res.organization, function(key, value) {

                                $.each(value.organizations, function(key, org) {

                                    $('#organization_search').append('<option value="' + org
                                        .id + '">' + org.name + '</option>').css("text-transform", "capitalize");
                                })

                            });

                        }
                    }

                })
            }

        });
    </script>
@endpush
