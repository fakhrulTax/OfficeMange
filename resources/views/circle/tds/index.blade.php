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
                </div>

            </div>
        </div>

    </div>

    <section class="content">
        <div class="card">
            <div class="card-body bg-success">

              @if(isset($updateType)  && $updateType == 'edit')
              <form action="{{ route('circle.tds.update', $editTds->id) }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zilla">Zilla</label>
                           <input type="text" value="{{ $editTds->upazila->zilla->name }}" class="form-control" readonly>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="upazila">Upazilla</label>
                            <input type="text" value="{{ $editTds->upazila->name }}" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="organization">Organization</label>
                            <input type="text" value="{{ $editTds->organization->name }}" class="form-control" readonly>
                        </div>
                    </div>




                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="collection_month">Collection Month</label>
                            <input type="month" name="collection_month"
                                placeholder="collection month" value="{{ $editTds->collection_month }}" class="form-control" autofocus>
                        </div>
                    </div>


                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="bill">Bill</label>
                            <input type="number" value="{{ $editTds->bill }}"  name="bill" placeholder="bill" class="form-control"
                                autofocus>
                        </div>
                    </div>



                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tds">TDS</label>
                            <input type="number" id="tds" name="tds" placeholder="TDS" class="form-control"
                                value="{{ $editTds->tds }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="comments">Comment</label>
                        <div class="form-group">
                            <textarea name="comments" id="" cols="30" rows="1" class="form-control">{{ $editTds->comments }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-3 mt-4">
                        <input type="submit" value="Update TDS" class="btn btn-primary  mt-2">

                    </div>

                </div>

            </form>



              @else
                <form action="{{ route('circle.tds.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zilla">Zilla</label>
                                <select class="form-control" id="zilla">
                                    <option value="">Select Zilla</option>
                                    @foreach ($zillas as $zilla)
                                        <option value="{{ $zilla->id }}">{{ $zilla->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="upazila">Upazilla</label>
                                <select class="form-control" name="upazila_id" id="upazila" required>
                                    <option value="">Select Upazilla</option>


                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="organization">Organization</label>
                                <select class="form-control" name="organization_id" id="organization" required>
                                    <option value="">Select Organization</option>


                                </select>
                            </div>
                        </div>




                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="collection_month">Collection Month</label>
                                <input type="month" id="collection_month" name="collection_month"
                                    placeholder="collection month" class="form-control" autofocus>
                            </div>
                        </div>


                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="bill">Bill</label>
                                <input type="number" id="bill" name="bill" placeholder="bill" class="form-control"
                                    autofocus>
                            </div>
                        </div>



                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tds">TDS</label>
                                <input type="number" id="tds" name="tds" placeholder="TDS" class="form-control"
                                    value="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="comments">Comment</label>
                            <div class="form-group">
                                <textarea name="comments" id="" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3 mt-4">
                            <input type="submit" value="Add TDS" class="btn btn-primary mt-2">

                        </div>

                    </div>

                </form>
              @endif
            </div>
        </div>
    

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
                                  <option value="{{ $zilla->id }}">{{ $zilla->name }}</option>
                              @endforeach
    
                          </select>
                      </div>
                  </div>
    
    
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="upazila_search">Upazilla</label>
                          <select class="form-control" name="upazila_search" id="upazila_search">
                              <option value="">Select Upazilla</option>
    
                          </select>
                      </div>
                  </div>
    
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="organization_search">Organization</label>
                          <select class="form-control" name="organization_search" id="organization_search" >
                              <option value="">Select Organization</option>
    
    
                          </select>
                      </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                        <label for="collection_month">Collection Month</label>
                      <input type="month" name="collection_month" class="form-control">

                    </div>
                </div>

                  <div class="col-md-2">
                    <div class="form-group mt-4">
                      <input type="submit" class="btn btn-primary mt-2" value="Search">
                    </div>
                </div>
    
              </div>
            </form>
          </div>
        </div>






        <div class="card">

            @if (count($tds) < 1)

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

                                <th>Bill</th>
                                <th>TDS</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($tds as $key => $tds)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        {{ date('M-Y', strtotime($tds->collection_month)) }}<br>

                                    </td>
                                    <td> {{ $tds->upazila->zilla->name }}</td>
                                    <td> {{ $tds->upazila->name }}</td>
                                    <td> {{ $tds->organization->name }} </td>
                                    <td> {{ $tds->bill }} </td>
                                    <td>
                                        {{ $tds->tds }}
                                    </td>
                                    <td> {{ $tds->comments }} </td>
                                    <td> 
                                      <a href="{{ route('circle.tds.edit', $tds->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                      <a href="{{ route('circle.tds.destroy', $tds->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this TDS?')">Delete</a>
                                    
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="font-weight-bold text-center">Total</td>
                                <td>{{ $tds->sum('bill') }}</td>
                                <td>{{ $tds->sum('tds') }}</td>
                                <td colspan="2"></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
             

            @endif

        </div>
        <!-- /.card -->



    </section>




@endsection

@push('js')
    <script>
        $('#zilla').change(function() {
            var zilla = $(this).val();
            $('#upazila').empty();

            if (zilla) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('upazilla') }}/" + zilla,
                    dataType: "json",

                    success: function(res) {
                        if (res) {
                            $('#upazila').empty();


                            $('#upazila').append('<option>Select Upazilla</option>');
                            $.each(res.upazilla, function(key, value) {
                                $('#upazila').append('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });

                        }
                    }



                });
            }


        });

        $('#upazila').change(function() {
            var upazila = $(this).val();

            if (upazila) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ogranization') }}/" + upazila,
                    dataType: "json",

                    success: function(res) {
                        if (res) {

                            $('#organization').empty();

                            $('#organization').append('<option>Select Organization</option>');
                            $.each(res.organization, function(key, value) {

                                $.each(value.organizations, function(key, org) {

                                    $('#organization').append('<option value="' + org
                                        .id + '">' + org.name + '</option>');
                                })

                            });

                        }
                    }

                })
            }

        });




        $('#zilla_search').change(function() {
            var zilla = $(this).val();
            $('#upazila_search').empty();
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
                                    .name + '</option>');
                            });

                        }
                    }



                });
            }


        });

        $('#upazila_search').change(function() {
            var upazila = $(this).val();

            if (upazila) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ogranization') }}/" + upazila,
                    dataType: "json",

                    success: function(res) {
                        if (res) {

                            $('#organization_search').empty();

                            $('#organization_search').append('<option value="">Select Organization</option>');
                            $.each(res.organization, function(key, value) {

                                $.each(value.organizations, function(key, org) {

                                    $('#organization_search').append('<option value="' + org
                                        .id + '">' + org.name + '</option>');
                                })

                            });

                        }
                    }

                })
            }

        });
    </script>
@endpush
