@extends('app')



@section('title', 'Circle | TDS | Contact Person')



@section('content')



    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0">Contact Person</h1>

                </div>



                <div class="col-md-6">

                    <ol class="breadcrumb float-sm-right">

                        <a href="{{ route('circle.tds.contactPerson.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add New Contact Person</a>

                    </ol>

                </div>



            </div>

        </div>



    </div>



    <section class="content">    





        <div class="card">

            <div class="card-body">
            
            @if( $Auth::user()->user_role == 'commissioner' )
                <form action="{{ route('commissioner.tds.contactPerson.search') }}" method="GET">
            @elseif( $Auth::user()->user_role == 'range' )
                <form action="{{ route('range.tds.contactPerson.search') }}" method="GET">
            @else
              <form action="{{ route('circle.tds.contactPerson.search') }}" method="GET">
            @endif

                <div class="row">

          

                    <div class="col-md-2">

                        <div class="form-group">

                            <label for="zilla">Zilla</label>

                            <select class="form-control" name="zilla_id" id="zilla_id">

                                <option value="">Select Zilla</option>

                                @foreach ($zillas as $zilla)

                                    <option value="{{ $zilla->id }}" {{ Request::get('zilla_id') == $zilla->id ? 'selected' : ''}} >{{ ucfirst($zilla->name) }} </option>

                                @endforeach

          

                            </select>

                        </div>

                    </div>

          

          

                    <div class="col-md-2">

                        <div class="form-group">

                            <label for="upazila_id">Upazilla</label>

                            <select class="form-control" name="upazila_id" id="upazila_id">

                                <option value="">Select Upazilla</option>



                                @if (Request::get('zilla_id'))



                                @php

                                    $uapzilas = App\Models\Upazila::where('zilla_id', Request::get('zilla_id'))->get();

                                @endphp

                                

                                @foreach ($uapzilas as $uapzila )

                                <option value="{{ $uapzila->id }}" {{ Request::get('upazila_id') == $uapzila->id ? 'selected' : ''}} > {{ ucfirst($uapzila->name)}} </option>

                                @endforeach

                                    

                                @endif

          

                            </select>

                        </div>

                    </div>

          

                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="organization_id">Organization</label>

                            <select class="form-control" name="organization_id" id="organization_id" >

                                <option value="">Select Organization</option>

                                @if (Request::get('upazila_id'))



                                @php

                                    $organizations = App\Models\Upazila::where('id', Request::get('upazila_id'))->first()->organizations;
                                    
                                    

                                @endphp



                                @foreach ($organizations as $organization )

                                <option value="{{ $organization->id }}" {{ Request::get('organization_id') == $organization->id ? 'selected' : ''}} > {{ ucfirst($organization->name) }} </option>

                                @endforeach

                                    

                                @endif
          

                            </select>



                          

                        </div>

                    </div>

          
                    @if($Auth::user()->user_role != 'circle')
                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="circle">Circle</label>
                            <select name="circle" id="circle" class="form-control">
                                <option value="">Circle</option>
                                @foreach($circles as $circle)
                                    <option value="{{ $circle }}" {{ Request::get('circle') == $circle ? 'selected' : ''}}>{{ $circle }}</option>
                                @endforeach
                            </select>


                        </div>

                    </div>
                    @endif


          

                    <div class="col-md-2">

                      <div class="form-group">

                        <input type="submit" class="btn btn-primary" value="Search" style="margin-top: 30px">

                      </div>

                  </div>

          

                </div>

              </form>

            </div>

          </div>

          









        <div class="card">





            @if (count($persons) < 1)

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>

            @else

                <!-- /.card-header -->

                <div class="card-body">

                    <table id="movement_table" class="table  table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Zilla</th>

                                <th>Upazila</th>

                                <th>Authority</th>

                                <th>Name & Designation</th>
                                <th>Mobile & E-mail</th>   

                                <th>Circle</th>
                                @if($Auth::user()->user_role == 'circle')
                                    <th>Action</th>
                                @endif

                            </tr>

                        </thead>



                        <tbody>



                            @foreach ($persons as $key => $person)



                                <tr>

                                    <td>{{ ++$key }}</td>

                                    <td>

                                        {{ $person->zilla->name }}

                                    </td>

                                    <td> {{ $person->upazila->name }}</td>

                                    <td> {{ $person->organization->name }}</td>
                                    

                                    <td> 
                                        {{ ucfirst($person->name )}} <br>
                                        {{ ucfirst($person->designation )}} 
                                     </td>

                                    <td>

                                    {{ $person->mobile_number }} <br>
                                    {{ $person->email }}

                                    </td>
                                    <td>{{ $person->circle }}</td>
                                    @if($Auth::user()->user_role == 'circle')
                                    <td> 

                                      <a href="{{ route('circle.tds.contactPerson.edit', $person->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                   

                                    </td>
                                    @endif



                                </tr>



                            @endforeach



                        </tbody>

                        <tfoot>


                        </tfoot>

                    </table>

                </div>

                <!-- /.card-body -->

             



            @endif



        </div>

        <!-- /.card -->



   <div class="card-footer clearfix">

        <ul class="pagination pagination-sm m-0 float-right">



            {{ $persons->links("pagination::bootstrap-4") }}



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