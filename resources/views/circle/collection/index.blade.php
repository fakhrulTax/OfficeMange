@extends('app')

@push('css')
   
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Collections</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('circle.collection.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add Collection</a>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

             @if( count($collections) < 1  )

                <h2 class="text-danger">Sorry! There is no data to show!</h2>
                
             @else

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-primary table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>TIN & Name</th>
                            <th>Payment Date</th>
                            <th>Ass. Year</th>
                            <th>Amount</th>
                            <th>Challan No & Date</th>
                            <th>Option</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php $sum = 0; ?>
                    @foreach ($collections as $key => $collection)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td> {{ $collection->type }}</td>
                            <td>{{ $collection->tin }} <br>
                                {{ $collection->stock->name }}
                            </td>                            
                            <td>{{ date('d-m-Y',strtotime($collection->pay_date)) }}</td>
                            <td> {{ $collection->assessment_year }}</td>
                            <td> {{ $collection->amount }}</td>
                            <td> {{ $collection->challan_no }} <br>
                                 {{ date('d-m-Y',strtotime($collection->challan_date)) }}
                            </td>
                            <td>
                                <a href="{{ route('circle.collection.edit',$collection->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                        <?php $sum = $sum + $collection->amount; ?>
                    @endforeach                 

                    <tr>
                        <td colspan="5">Total</td>
                        <td colspan="2">{{ $sum }}</td>
                    </tr>


                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
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