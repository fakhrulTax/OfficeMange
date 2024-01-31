@extends('app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card my-5">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form id="resetPasswordForm" method="POST" action="{{ route('passwordReset') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <div id="passwordError" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="user_otp" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="user_otp" type="number" class="form-control" name="user_otp" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


@push('js')

<script>
    $(document).ready(function() {
        $('#resetPasswordForm').submit(function(event) {
            var password = $('#password').val();
            var passwordError = $('#passwordError');
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordPattern.test(password)) {
                passwordError.text('Password must be 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.');
                passwordError.show();
                event.preventDefault(); // Prevent form submission
            } else {
                passwordError.hide();
            }
        });
    });
</script>
    
@endpush
