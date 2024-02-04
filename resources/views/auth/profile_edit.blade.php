@extends('app')
@section('title', 'Profile Edit')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile Edit </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">



                <form action="{{ route('profile.update', $user->id) }}" id="addUserForm" method="POST">
                    @csrf


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>

                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror


                            </div>




                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="designation">Designation <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="designation" name="designation"
                                     value="{{  $user->designation }}" required>

                                @error('designation')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>


                        </div>




                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number <span class="text-danger">*</span> </label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                   value="{{  $user->mobile_number }}" required>

                                    @error('mobile_number')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="office_name">Office Name (Optional) </label>
                                <input type="text" class="form-control" id="office_name" name="office_name"
                                  value="{{  $user->office_name }}">

                                    @error('office_name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                     
                       
                       

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" value="Update Profile Information" class="btn btn-primary btn-block">
                            </div>
                        </div>



                    </div>


                </form>


            </div>



        </div>

    </div>
@endsection

    

