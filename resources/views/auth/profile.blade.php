@extends('app')

@section('title', 'Profile')

@section('content')

<section class="content">
      
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="card w-75">
                <div class="card-header">
                    <h3 class="card-title">User Profile</h3>
                </div>
                <div class="card-body">
                    <h5>Name: {{ $user->name }}</h5>
        
                    <h5>Designation: {{ $user->designation }}</h5>
        
        
                    <h5>User Type: {{ $user->user_role }}</h5>
        
        
                    @if ($user->range)
                        <h5>Range: {{ $user->range }}</h5>
                    @endif
        
                    @if ($user->circle)
                        <h5>Circle: {{ $user->circle }}</h5>
                    @endif
        
                    <h5>Phone: {{ $user->mobile_number }}</h5>
        
                    <h5 class="">Email: {{ $user->email }}</h5>
        
                    <h5 class="">Office Name: {{ $user->office_name }}</h5>
                    
                </div>

                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary"> Edit </a>
            </div>

        </div>
    </div>


    

</section>




@endsection