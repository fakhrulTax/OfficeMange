<!-- resources/views/verify_otp.blade.php -->

@extends('app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Verify OTP </h1>
            </div>
            
        </div>
    </div>

</div>

<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
        
                    <form method="POST" action="{{ route('verifyOTP') }}">
                        @csrf
                        <div class="row">
        
        
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="otp">OTP <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
        
                                </div>
                            </div>
        
                            <div class="col-md-12">
                                <div class="form-group">
                                   
                                    <input type="submit" class="btn btn-primary" value="Verify OTP">
        
                                </div>
                            </div>
        
                        </div>
                        
                    </form>
                    
        
                </div>
        
            </div>
        </div>
    </div>

    
</section>



@endsection