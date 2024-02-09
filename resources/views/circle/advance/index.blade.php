@extends('app')
@section('title','Advances')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Advance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{ route('circle.advance.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Advance</a>
                </ol>
            </div>
        </div>
    </div>

</div>

<section class="content">

    <div class="card">

        @if( count($advances) < 1  )

           <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
           
        @else

       <!-- /.card-header -->
       <div class="card-body">
           <table id="example1" class="table table-primary table-bordered table-striped">
               <thead>
                   <tr>
                       <th>#</th>
                       <th>Advance Assessment Year</th>
                       <th>TIN & Name</th>
                       <th>Last Submitted Year</th>
                       <th>Income</th>
                       <th>Tax</th>
                       <th>Action</th>
                      
                   </tr>
               </thead>

               <tbody>


               @foreach ($advances as $key => $advance)
                   <tr>
                       <td>{{ ++$key }}</td>
                       <td> {{ App\Helpers\MyHelper::assessment_year_format($advance->advance_assessment_year) }}</td>
                       <td>{{ $advance->tin }}    </td>   
                       
                       <td>
                        {{ App\Helpers\MyHelper::assessment_year_format($advance->return_submitted_assessment_year) }}
                    </td> 

                     
                       <td> {{ App\Helpers\MyHelper::moneyFormatBD($advance->income) }}</td>

                       <td> {{ App\Helpers\MyHelper::moneyFormatBD($advance->tax) }}</td>
                    
                       <td>
                           <a href="{{ route('circle.advance.edit',$advance->id) }}" class="btn btn-sm btn-primary">Edit</a>

                           <a href="{{ route('circle.advance.destroy',$advance->id) }}"  class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" >Delete</a>

                       </td>
                   </tr>
                  
               @endforeach                 

               <tr>
                   <td colspan="4" class="text-center font-weight-bold">Total</td>
                   <td>{{ App\Helpers\MyHelper::moneyFormatBD( $advances->sum('income')  ) }}</td>
                   <td >{{ App\Helpers\MyHelper::moneyFormatBD( $advances->sum('tax') ) }}</td>
                   <td></td>
               </tr>


               </tbody>
               <tfoot>

               </tfoot>
           </table>
       </div>
       <!-- /.card-body -->

       <div class="card-footer">
         <ul class="pagination pagination-sm m-0 float-right">
           {{ $advances->links("pagination::bootstrap-4") }}
         </ul>
       </div>

       @endif

   </div>
    
</section>


@endsection