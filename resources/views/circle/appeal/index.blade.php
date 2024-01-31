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
                          <option value="">Register Type</option>
                          <option value="appeal" @if( !empty($search->type) && $search->type =='appeal' ){{'selected'}}@endif>Appeal</option>
                          <option value="tribunal" @if( !empty($search->type) && $search->type =='tribunal' ){{'selected'}}@endif>Tribunal</option>
                          <option value="high_court"@if( !empty($search->type) && $search->type =='high_court' ){{'selected'}}@endif>High Court</option>
                          <option value="review"@if( !empty($search->type) && $search->type =='review' ){{'selected'}}@endif>Review</option>
                        </select>
                      </div>
                    </div>

                   <div class="col-md-2">
                     <div class="form-group">
                       <input type="text" id="from_date" name="from_date" placeholder="Disposal Date From" class="form-control" value="@if( !empty($search->from_date) ){{ date('d-m-Y', strtotime($search->from_date)) }}@endif">
                     </div>
                   </div>

                   <div class="col-md-2">
                     <div class="form-group">
                       <input type="text" id="to_date" name="to_date" placeholder="To Date" class="form-control"  value="@if( !empty($search->from_date) ){{ date('d-m-Y', strtotime($search->to_date)) }}@endif">
                     </div>
                   </div>

                   <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                   </div>

                   <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Download</button>
                   </div>

                 </div>
                 
               </form>
            </div>
        </div>


        <div class="card">

             @if( count($appeals) < 1  )

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->

            <div class="card-body">
                <table id="appeal" class="table table-secondary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Register Type</th>
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
                            <td> {{ ucfirst($appeal->type) }}</td>
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
                              <span style="border-bottom: 1px solid #000000">{{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_income) }} </span> <br>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_tax) }}
                            </td>
                            <td> 
                            <span style="border-bottom: 1px solid #000000">{{ App\Helpers\MyHelper::moneyFormatBD($appeal->revise_income) }}</span> <br>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->revise_tax) }}
                            </td>
                            <td>
                              {{ App\Helpers\MyHelper::moneyFormatBD($appeal->main_tax - $appeal->revise_tax) }}
                            </td>
                            <td>{{ $appeal->circle }}</td>
                            <td>
                                <a href="{{ route('circle.appeal.edit', $appeal->id) }}" class="btn btn-sm btn-primary">Edit</a>
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