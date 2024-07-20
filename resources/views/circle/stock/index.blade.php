@extends('app')

@section('title', 'Stocks')

@push('css')
    <style>
        .address p {
            margin: 0;
        }
    </style>
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stocks({{ count($stocks) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#addModal"><i class="fas fa-plus"></i> Add Tax Payer</button>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <!-- card heder -->
            <div class="card-header">
                <form action="{{ route('circle.stockSearch') }}" method="GET">              
                 <div class="row">
                   <div class="col-md-4">
                     <div class="form-group">
                       <label for="tin">TIN</label>
                       <input type="number" id="tin" name="tin" placeholder="TIN" class="form-control" value="{{ isset($search->tin)?$search->tin: '' }}" autofocus>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                       <label for="name">Name</label>
                       <input type="text" id="name" name="name" placeholder="Name" class="form-control" value="{{ isset($search->name)?$search->name:'' }}">
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                       <label for="file_has">Files?</label>
                       <select name="file_has" id="file_has" class="form-control">
                         <option value="">File Has?</option>
                         <option value="1" {{ (isset($search->file_has) && $search->file_has == 1)?'selected':'' }}>Yes</option>
                         <option value="0" {{ (isset($search->file_has) && $search->file_has == 0)?'selected':'' }}>No</option>
                       </select>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-md-4">
                     <div class="form-group">
                      <label for="last_return">Last Return Year</label>
                       <input type="number" name="last_return" placeholder="Last Return" class="form-control" value="{{ isset($search->last_return)?$search->last_return: '' }}">
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                       <label for="default_year">Default Year</label>
                       <input type="number" id="default_year" name="default_year" placeholder="Default Year" class="form-control" value="{{ isset($search->default_year)?$search->default_year: '' }}">
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                       <label for="sort_by">Sort By</label>
                       <select name="sort_by" id="sort_by" class="form-control">
                         <option value="">Sort By</option>
                         <option value="tin" {{ (isset($search->sort_by) && $search->sort_by == 'tin')?'selected':'' }}>TIN</option>
                         <option value="sort_name" {{ (isset($search->sort_by) && $search->sort_by == 'name')?'selected':'' }}>Name</option>
                       </select>
                     </div>
                   </div>
                   <div class="col-md-2">
                     <div class="form-group">
                       <label for="asc_desc">Sort Type</label>
                       <select name="asc_desc" id="asc_desc" class="form-control">
                         <option value="">Sort Type</option>
                         <option value="ASC" {{ (isset($search->asc_desc) && $search->asc_desc == 'ASC')?'selected':'' }}>ASC</option>
                         <option value="DESC" {{ (isset($search->asc_desc) && $search->asc_desc == 'DESC')?'selected':'' }}>DESC</option>
                       </select>
                     </div>
                   </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Search</button>
               </form> 
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TIN</th>
                            <th>Name, Address</th>
                            <th>Type</th>
                            <th>File</th>
                            <th>Rack</th>
                            <th>Last Return</th>
                            <th>Circle</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($stocks as $key => $stock)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $stock->tin }}</td>
                                <td> 
                                    {{ $stock->name }} <br>
                                    {{ $stock->bangla_name }}
                                    <span class="address">
                                        {!! $stock->address !!}
                                    </span>                                    
                                </td>
                                <td> {{ $stock->type }}</td>
                                <td>{{ $stock->file_in_stock ? 'Yes' : 'No' }}</td>
                                <td>{{ $stock->file_rack }}</td>
                                <td> {{ $stock->last_return }} </td>
                                <td>{{ $stock->circle }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="edit({{ $stock->id }})">Edit</button>
                                    <a href="{{ route('circle.stock.env',$stock->tin) }}" target="_blank" class="btn btn-sm btn-warning">ENV</a>
                                    <a href="{{ route('circle.stock.view', $stock->id) }}"
                                        class="btn btn-success btn-sm">Notice</a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

            <!-- card-footer -->
            <div class="card-footer">
                <ul class="pagination pagination-sm m-0 float-right">
                  {{ $stocks->links("pagination::bootstrap-4") }}
                </ul>
            </div>
            <!-- card-footer -->
        </div>
        <!-- /.card -->

    </section>


    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add A Tax Payer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-12">
                        <p class="text-danger error">

                        </p>
                    </div>

                    <form action="" method="POST" id="add-tax-payer-form">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tin">TIN Number</label>
                                    <input type="number" class="form-control" id="tin" name="tin"
                                        placeholder="6540656206">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Abdul Karim ">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bangla_name">Bangla Name</label>
                                    <input type="text" class="form-control" id="bangla_name" name="bangla_name"
                                        placeholder="Tax Payer name in bangla">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="tel" class="form-control" id="mobile" name="mobile"
                                        placeholder="01712000000">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="abcd@gmail.com">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tax Payer Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="individual">Individual</option>
                                        <option value="firm">Firm</option>
                                        <option value="company">Company</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_in_stock">File In Stock?</label>
                                    <select name="file_in_stock" id="file_in_stock" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_return">Last Return Submission Year</label>
                                    <input type="number" class="form-control" id="last_return" name="last_return"
                                        placeholder="20232024">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_rack">File Rack</label>
                                    <select name="file_rack" id="file_rack" class="form-control">
                                        <option value="">File Rack</option>
                                        @for( $i = 1; $i<=9; $i++ )                                        
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor                                        
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_line_one">Address (Fillup 3 lines)</label>
                                    <input type="text" class="form-control" id="address_line_one"
                                        name="address_line_one" placeholder="Address Line One">


                                    <input type="text" class="form-control mt-1" id="address_line_two"
                                        name="address_line_two" placeholder="Address Line Two">


                                    <input type="text" class="form-control mt-1" id="address_line_three"
                                        name="address_line_three" placeholder="Address Line Three">


                                </div>
                            </div>



                        </div>
                    </form>



                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addBtn">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit A Tax Payer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{-- Edit Form load here from ajax --}}

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection



@push('js')
    

    <script>
        $(document).ready(function() {

            $('#addBtn').on('click', function() {
                $data = $('#add-tax-payer-form').serialize();
                $.ajax({
                    url: "{{ route('circle.stockStore') }}",
                    type: "POST",
                    data: $data,
                    success: function(data) {
                        if (data.status != 200) {

                            $('.error').text(data.message);
                        } else {
                            $.toast({
                                heading: "Success",
                                text: "Tax Payer Added successfully",
                                position: "top-right",
                                loaderBg: "#5ba035",
                                icon: "success",
                                hideAfter: 3e3,
                                stack: 1,

                            });

                            $('#modal-lg').modal('hide');
                            $('#add-tax-payer-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            });
        });


        function edit(id) {
            $.ajax({
                url: "{{ route('circle.stockEdit') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#editModal').modal('show');
                    $('#editModal').find('.modal-body').html(data);
                }


            })
        }


        $(document).ready(function() {
            $('#updateBtn').on('click', function() {
                $data = $('#edit-tax-payer-form').serialize();
                $.ajax({
                    url: "{{ route('circle.stockUpdate') }}",
                    type: "POST",
                    data: $data,
                    success: function(data) {
                        if (data.status != 200) {

                            $('.error').text(data.message);

                        } else {

                            $.toast({
                                heading: "Success",
                                text: "Tax Payer Updated successfully",
                                position: "top-right",
                                loaderBg: "#5ba035",
                                icon: "success",
                                hideAfter: 3e3,
                                stack: 1,

                            });

                            $('#editModal').modal('hide');
                            $('#edit-tax-payer-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            })
        })
    </script>
@endpush
