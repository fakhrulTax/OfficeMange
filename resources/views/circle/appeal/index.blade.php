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

            <div class="card-body">
                <table id="appeal" class="table table-primary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>TIN & Name</th>
                            <th>Appeal Order And Date</th>
                            <th>Disposal Date</th>
                            <th>Assessment Year</th>
                            <th>Main Income & Tax</th>
                            <th>Revise Income & Tax</th>
                            <th>Reduce</th>
                            <th>Circle</th>
                            <th>Option</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach ($appeals as $key => $appeal)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td> {{ $appeal->type }}</td>
                            <td>{{ $appeal->tin }} <br>
                                {{ $appeal->stock->name }}
                            </td>                            
                            <td>
                              {{ $appeal->appeal_order }} <br>
                              {{ date('d-m-Y',strtotime($appeal->appeal_order_date)) }}
                            </td>
                            <td>{{ date('d-m-Y',strtotime($appeal->appeal_disposal_date)) }}</td>
                            <td> {{ App\Helpers\MyHelper::assessment_year_format($appeal->assessment_year) }}</td>
                            <td> 
                              <span style="text-decoration: underline">{{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_income) }} </span> <br>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_tax) }}
                            </td>
                            <td> 
                            <span style="text-decoration: underline">{{ App\Helpers\MyHelper::moneyFormatBD($appeal->revise_income) }}</span> <br>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->revise_tax) }}
                            </td>
                            <td>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_tax - $appeal->revise_tax) }}
                            </td>
                            <td>
                                <a href="{{ route('circle.appeal.edit',$appeal->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach       

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>   
             
            <!-- /.card-body -->

            <div class="card-footer">
              <ul class="pagination pagination-sm m-0 float-right">
                {{ $appeals->links("pagination::bootstrap-4") }}
              </ul>
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