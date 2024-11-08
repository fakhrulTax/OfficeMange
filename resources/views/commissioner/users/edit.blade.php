@extends('app')
@section('title', 'Edit User')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update User</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">



                <form action="{{ route('commissioner.user.update', $user->id) }}" id="editUserForm" method="POST">
                    @csrf


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_role"> User Type <span class="text-danger">*</span> </label>
                                <select name="user_role" class="form-control" id="user_role" >
                                    <option value="" >Select User Type</option>

                                    <option value="range" {{ $user->user_role == 'range' ? 'selected' : '' }} >Range</option>
                                    <option value="circle" {{ $user->user_role == 'circle' ? 'selected' : '' }}>Circle</option>
                                    <option value="technical" {{ $user->user_role == 'technical' ? 'selected' : '' }} >Technical</option>



                                </select>
                                @error('user_role')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>





                        </div>


                        <div class="col-md-6" id="range">
                            <div class="form-group">
                                <label for="range"> Range <span class="text-danger">*</span> </label>
                                <select name="range" class="form-control range" >
                                    <option value="">Select Range</option>

                                    @php
                                    $i = 1;
                                    @endphp
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{$i}}" {{ $user->range == $i ? 'selected' : ''}} >Range {{$i}}</option>
                                    @endfor

                                </select>


                                @error('range')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror

                            </div>


                        </div>


                        <div class="col-md-6" id="circle">
                            <div class="form-group">
                                <label for="circle"> Circle <span class="text-danger">*</span> </label>
                                <select name="circle"class="form-control circle" >
                                    <option value="">Select Circle</option>

                                    @php
                                    $i = 1;
                                    @endphp
                                    @for ($i = 1; $i <= 22; $i++)
                                        <option value="{{$i}}" {{ $user->circle == $i ? 'selected' : ''}}>Circle {{$i}}</option>
                                    @endfor
                                    




                                </select>

                            @error('circle')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror


                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Mr. Kasem" value="{{ $user->name }}" >

                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror


                            </div>




                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="designation">Designation <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="designation" name="designation"
                                    placeholder="Officer" value="{{ $user->designation }}" >

                                @error('designation')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>


                        </div>




                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number <span class="text-danger">*</span> </label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                    placeholder="01811000000" value="{{ $user->mobile_number }}" >

                                    @error('mobile_number')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="office_name">Office Name (Optional) </label>
                                <input type="text" class="form-control" id="office_name" name="office_name"
                                    placeholder="Noakhali Office" value="{{ $user->office_name }}">

                                    @error('office_name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span> </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="abc@gmail.com" value="{{ $user->email }}">

                                    @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger"></span> </label>
                                <input type="password" class="form-control" id="password"  name="password" value="" autocomplete="new-password">

                                @error('password')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_otp">OTP(6 digit) <span class="text-danger">*</span> </label>
                                <input type="number" class="form-control" id="user_otp" name="user_otp" value="111111" required>

                                @error('user_otp')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" value="Update User" class="btn btn-primary btn-block">
                            </div>
                        </div>



                    </div>


                </form>


            </div>



        </div>

    </div>
@endsection




@push('js')
    <script>
    $(document).ready(function() {
       
        $('#user_role').change(function() {
            let user_role = $(this).val();
            if(user_role == 'range'){
                $('#range').show();
                $('.range').attr('required','required');
                $('#circle').hide();
                $('.circle').removeAttr('required');
                
            }else if(user_role == 'circle'){
                $('#range').hide();
                $('.range').removeAttr('required'); 
                $('#circle').show();                 
                $('.circle').attr('required','required');
                
            }else {
                $('#range').hide();
                $('#circle').hide();
                $('.circle').removeAttr('required');
                $('.range').removeAttr('required')
            }
        })
    });


</script>
    
@endpush

