@extends('app')
@section('title',$title)

@push('css')
   
@endpush


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appeal Trivunal High Court & Review</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('circle.appeal.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Appeal</a>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">
            <div class="card-body">
            <form action="{{ route('circle.appeal.search') }}" method="GET">              
                 <div class="row">

                  <div class="col-md-3">
                     <div class="form-group">
                       <input type="number" id="tin" name="tin" placeholder="TIN" class="form-control" value="@if( !empty($search->tin) ){{ $search->tin }}@endif" autofocus>
                     </div>
                   </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <select class="form-control" name="type" id="type">
                          <option value="">Select Type</option>
                          <option value="advance" @if( !empty($search->type) && $search->type =='advance' ){{'selected'}}@endif>Advance</option>
                          <option value="arrear" @if( !empty($search->type) && $search->type =='arrear' ){{'selected'}}@endif>Arrear</option>
                          <option value="return_process"@if( !empty($search->type) && $search->type =='return_process' ){{'selected'}}@endif>Return Process</option>
                        </select>
                      </div>
                    </div>

                   <div class="col-md-2">
                     <div class="form-group">
                       <input type="text" id="from_date" name="from_date" placeholder="Date From" class="form-control" value="@if( !empty($search->from_date) ){{ date('d-m-Y', strtotime($search->from_date)) }}@endif">
                     </div>
                   </div>

                   <div class="col-md-2">
                     <div class="form-group">
                       <input type="text" id="to_date" name="to_date" placeholder="To Date" class="form-control"  value="@if( !empty($search->from_date) ){{ date('d-m-Y', strtotime($search->to_date)) }}@endif">
                     </div>
                   </div>

                   <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                   </div>

                 </div>
                 
               </form>
            </div>
        </div>


        <div class="card">

             @if( count($appeals) < 1  )

                <h2 class="text-danger">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->
            
            <!-- /.card-body -->

            @endif

        </div>
        <!-- /.card -->

    </section>


    
@endsection



@push('js')
    <script>     



    </script>
@endpush