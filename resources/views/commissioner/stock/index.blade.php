@extends('app')

@section('title', 'Stocks')

@push('css')
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h1 class="m-0">Stocks</h1>
                </div>        
                
                <div class="col-md-4">

                    <form action="{{ route('commissioner.stock.upload') }}" method="POST" enctype="multipart/form-data" target="_blank">
                    @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="stockFile" name="stockFile">
                                <label class="custom-file-label" for="stockFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text">Upload</button>
                            </div>
                        </div>                        
                    </form>

                </div>

                <div class="col-md-2"></div>

                <div class="col-md-3">
                    <a href="{{ asset('downloads/stocksSample.xlsx') }}" class="btn btn-primary" download>Download Sample File</a>
                </div>

            </div>
        </div>

    </div>

    <section class="content">

    <div class="card">
            <div class="card-body">
                <form action="{{ route('commissioner.stock.search') }}" method="GET">
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="number" id="tin" name="tin" placeholder="TIN" class="form-control"
                                    value="{{ isset($search->tin) ? $search->tin : '' }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" id="name" name="name" placeholder="Name" class="form-control"
                                    value="{{ isset($search->name) ? $search->name : '' }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="type" class="form-control">
                                    <option value="">Type</option>
                                    <option value="individual" {{ (isset($search->type) && $search->type == 'individual') ? 'selected' : '' }}>Individual</option>
                                    <option value="firm" {{ (isset($search->type) && $search->type == 'firm') ? 'selected' : '' }}>Firm</option>
                                    <option value="company" {{ (isset($search->type) && $search->type == 'company') ? 'selected' : '' }}>Company</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="file_in_stock" class="form-control">
                                    <option value="">File In Stock?</option>
                                    <option value="1" {{ (isset($search->file_in_stock) && $search->file_in_stock == 1) ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ (isset($search->file_in_stock) && $search->file_in_stock == 0) ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="circle" class="form-control">
                                    <option value="">Circle</option>
                                    @for( $i =1; $i <=22; $i++ )
                                        <option value="{{ $i }}" {{ (isset($search->circle) && $search->circle == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
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

            @if (count($stocks) < 1)
                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-primary table-bordered table-default">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TIN and Name</th>
                                <th>Type</th>
                                <th>File in Stock?</th>
                                <th>Circle</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>

                        <tbody>

                            
                            @foreach ($stocks as $key => $stock)

                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td> 
                                        {{ $stock->tin }} <br>
                                        {{ $stock->name }}
                                    </td>
                                    <td>{{ ucfirst( $stock->type ) }}</td>                                    
                                    <td>{{  $stock->file_in_stock ? 'Yes' : 'No' }}</td>
                                    <td>{{  $stock->circle }}</td>
                                    <td>
                                        <form action="{{ route('commissioner.stock.delete', $stock->id) }}" method="POST" id="deleteForm{{ $stock->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $stock->id }})">Del</button>
                                        </form>
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
                        {{ $stocks->links('pagination::bootstrap-4') }}
                    </ul>
                </div>
            @endif

        </div>
        <!-- /.card -->

    </section>



@endsection



@push('js')
<script>
    $(document).ready(function(){

        $('#stockFile').on('change', function(){
            // Get the file name
            var fileName = $(this).val().split('\\').pop();

            // Update the label text
            $(this).next('.custom-file-label').html(fileName);
        });

        
    });

    function confirmDelete(stockId) {
        if (confirm('Are you sure you want to delete this stock?')) {
            document.getElementById('deleteForm' + stockId).submit();
        }
    }
</script>
@endpush
