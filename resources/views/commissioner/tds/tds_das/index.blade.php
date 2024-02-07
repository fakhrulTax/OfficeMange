+@extends('app')

@section('title','Collections')

@push('css')
   
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TDS Collections</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>

    </div>

    <section class="content">

       <div class="row">



            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Collection</div>
                    <div class="card-body">
                        <h5 class="card-title">Primary card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>




       </div>

    </section>


    
@endsection



@push('js')
    <script>     



    </script>
@endpush