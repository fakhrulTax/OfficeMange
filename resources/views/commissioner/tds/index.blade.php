
@extends('app')

@section('title', 'TDS')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">TDS</h1>
            </div>
            
        </div>
    </div>

</div>




<div class="card">

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Zilla</th>
                    <th>Upazilla</th>
                    <th>Organization</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orgs as $key => $org )

                <tr>
                    <td>{{ ++$key }}</td>
                    <td> </td>
                </tr>
                    
                @endforeach

            </tbody>
        </table>
    </div>

</div>



@endsection