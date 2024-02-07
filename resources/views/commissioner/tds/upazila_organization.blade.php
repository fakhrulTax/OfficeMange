@extends('app')

@section('title', $title)

@push('css')
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upazila</h1>
                </div>

                <div class="col-md-6">                    
                </div>
              
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">

            @if (count($zillas) < 1)
                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <h2>Upazila Org</h2>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                </div>
            @endif

        </div>
        <!-- /.card -->

    </section>



@endsection



@push('js')
    <script>

    </script>
@endpush
