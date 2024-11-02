@extends('app')

@section('title', 'TDS | Contact Person')

@section('content')

<div class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                <h1 class="m-0">Edit Contact Person</h1>

            </div>



            <div class="col-md-6">

            </div>



        </div>

    </div>



</div>



<div class="card">

    <div class="card-body">



        <form action="{{ route('circle.tds.contactPerson.update', $contactPerson) }}" method="POST">

            @csrf     

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="zilla">Zilla</label>
                        <select class="form-control" id="zilla" name="zilla_id" required>
                            <option value="">Select Zilla</option>
                            @foreach ($zillas as $zilla)
                                <option value="{{ $zilla->id }}" {{ old('zilla_id') == $zilla->id || $zilla->id == $selectedDistictId ? 'selected' : ''}} >{{ ucfirst($zilla->name) }}</option>
                            @endforeach
                        </select>


                        @error('zilla_id')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>         
                         @enderror

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="upazila">Upazilla</label>
                        <select class="form-control" name="upazila_id" id="upazila" required autofocus>
                            <option value="">Select Upazilla</option>
                            @foreach( $selectedUpazilas as $upazila )
                                <option value="{{ $upazila->id }}" {{ $contactPerson->upazila_id == $upazila->id ? 'selected' : '' }}>{{ ucfirst($upazila->name) }}</option>
                            @endforeach
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

                        <select class="form-control" name="organization_id" id="organization" required>
                            @foreach( $authorities as $authority)

                            <option value="{{ $authority->id }}" {{ $contactPerson->organization_id == $authority->id ? 'selected' : '' }}>{{ $authority->name }}</option>

                            @endforeach
                        </select>



                        @error('organization_id')

                        <span class="text-danger" role="alert">

                            <strong> {{ $message }}</strong>

                        </span>

                            

                        @enderror

                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="name">Name</label>

                        <input type="text" id="name" name="name" 

                            placeholder="Name" class="form-control" value="{{ $contactPerson->name }}" required autocomplete="off" required>



                            @error('name')

                            <span class="text-danger" role="alert">

                                <strong> {{ $message }}</strong>

                            </span>

                                

                            @enderror

                    </div>

                </div>



                <div class="col-md-4">

                    <div class="form-group">

                        <label for="tds">Designation</label>

                        <input type="designation" id="designation" name="designation" placeholder="Designation" class="form-control" value="{{ $contactPerson->designation }}" required>

                            @error('designation')

                            <span class="text-danger" role="alert">

                                <strong> {{ $message }}</strong>

                            </span>

                                

                            @enderror

                    </div>

                </div>



                <div class="col-md-4">



                    <div class="form-group">

                        <label for="mobile_number">Mobile Number</label>

                        <input type="text" id="mobile_number" name="mobile_number" placeholder="mobile_number" class="form-control" value="{{ $contactPerson->mobile_number }}" required>



                            @error('mobile_number')

                            <span class="text-danger" role="alert">

                                <strong> {{ $message }}</strong>

                            </span>

                                

                            @enderror

                    </div>

                </div>


                <div class="col-md-4">



                    <div class="form-group">

                        <label for="email">Email</label>

                        <input type="email" id="email" name="email" placeholder="E-mail" class="form-control" value="{{ $contactPerson->email }}">



                            @error('email')

                            <span class="text-danger" role="alert">

                                <strong> {{ $message }}</strong>

                            </span>

                                

                            @enderror

                    </div>

                </div>     



                <div class="col-md-4 mt-4">

                    <input type="submit" value="Update Contact Person" class="btn btn-primary mt-2">

                </div>



            </div>



        </form>

 

    </div>

</div>







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

                                    .name + '</option>').css("text-transform", "capitalize");

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