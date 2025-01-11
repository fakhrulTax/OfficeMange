@extends('app')



@section('title', 'Circle | TDS | Contact Person')



@section('content')



    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0">Daily Collection</h1>

                </div>



                <div class="col-md-6">
                    <a href="{{ route('circle.daily.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i>Add Report</a>
                </div>


            </div>

        </div>



    </div>



    <section class="content">    

            <div class="card">
                <div class="card-body">
                @if( $Auth::user()->user_role == 'commissioner' )
                    <form action="{{ route('commissioner.daily.search') }}" method="get">
                @elseif( $Auth::user()->user_role == 'range' )
                    <form action="{{ route('range.daily.search') }}" method="get">
                @else
                    <form action="{{ route('circle.daily.search') }}" method="get">
                @endif


                        @csrf
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" id="issue_date" name="issue_date" value="{{ Request::get('issue_date') }}" placeholder="Report Date" class="form-control" autocomplete="off">
                                </div>
                            </div>                            

                         
                            <div class="col-md-3">

                                <div class="form-group">
                                    <select name="circle" id="circle" class="form-control">
                                        <option value="">Circle</option>
                                        @foreach($circles as $circle)
                                            <option value="{{ $circle }}" {{ Request::get('circle') == $circle ? 'selected' : ''}}>{{ $circle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                           

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </div>
                        
                    </form>
                </div>
            </div>


            @if (count($lastReports) < 1)

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>

            @else

            

                <!-- /.card-header -->

                <div class="card-body">

                    <table id="daily_report_table" class="table  table-bordered table-striped">

                        <thead>

                            <tr>
                                
                                <th>Date</th>
                                <th>Type</th>                              
                                <th>Number</th>                              
                                <th>Total Number</th>                              
                                <th>Collection</th>                              
                                <th>Total Collection</th>                              
                                <th>Action</th>                              

                            </tr>

                        </thead>



                        <tbody>

                          
                            @foreach($lastReports as $last)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($last->issue_date)->format('d-m-Y') }}</td>
                                    <td>{{ $last->type }}</td>
                                    <td> {{ $last->number }}</td>
                                    <td>{{ $last->total_number }}</td>                                
                                    <td>{{ $last->collection }}</td>                               
                                    <td>{{ $last->total_collection }}</td>
                                    <td><button class="btn btn-sm btn-default">edit</button></td>
                                </tr>
                            @endforeach
                          

                        </tbody>

                    </table>

                </div>

                <!-- /.card-body -->        



            @endif



        </div>

        <!-- /.card -->



  







    </section>









@endsection



@push('js')


@endpush