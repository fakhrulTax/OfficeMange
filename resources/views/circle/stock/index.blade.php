@extends('app')

@push('css')
    <!--  Datatable -->
<<<<<<< HEAD
=======

>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stocks({{count($Stocks)}})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
<<<<<<< HEAD
                            data-target="#modal-lg"><i class="fas fa-plus"></i> Add item</button>
=======
                            data-target="#addModal"><i class="fas fa-plus"></i> Add item</button>
>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
<<<<<<< HEAD
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 4.0
                            </td>
                            <td>Win 95+</td>
                            <td> 4</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 5.0
                            </td>
                            <td>Win 95+</td>
                            <td>5</td>
                            <td>C</td>
                        </tr>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 5.5
                            </td>
                            <td>Win 95+</td>
                            <td>5.5</td>
                            <td>A</td>
                        </tr>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 6
                            </td>
                            <td>Win 98+</td>
                            <td>6</td>
                            <td>A</td>
                        </tr>

                        </tfoot>
=======
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



                        @foreach ($Stocks as $key => $stock)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $stock->tin }}</td>
                                <td>{{ $stock->name }} <br>
                                    
                                {{ str_replace('</p><p>', ', ', strip_tags($stock->address)) }}


                                
                                
                                </td>
                                <td> {{ $stock->type }}</td>
                                <td>{{ $stock->file_in_stock ? 'Yes' : 'No' }}</td>
                                <td>{{ $stock->file_rack }}</td>
                                <td> {{ $stock->last_return }} </td>
                                <td>{{ $stock->circle }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="edit({{ $stock->id }})">Edit</button>
                                    <button class="btn btn-success btn-sm"
                                        onclick="view({{ $stock->id }})">View</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="notice({{ $stock->id }})">Notice</button>
                                </td>
                            </tr>
                        @endforeach








                    </tbody>
                    <tfoot>

                    </tfoot>
>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>


<<<<<<< HEAD
    <div class="modal fade" id="modal-lg">
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
                                <label for="bangla_name">Tax Payer Bangla Name</label>
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
                                    <option value="company">Company</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="circle">Circle</label>
                                <select name="circle" id="circle" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_in_stock">File In Stock</label>
                                <select name="file_in_stock" id="file_in_stock" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_return">Last Return Submission Year</label>
                                <input type="number" class="form-control" id="last_return" name="last_return"
                                    placeholder="abcd@gmail.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fiel_rack">File Rack</label>
                                <select name="fiel_rack" id="fiel_rack" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_one">Address</label>
                                <input type="text" class="form-control" id="address_line_one" name="address_line_one"
                                    placeholder="Address Line One">
                                 

                                    <input type="text" class="form-control mt-1" id="address_line_two" name="address_line_two"
                                    placeholder="Address Line Two">

                                    
                                    <input type="text" class="form-control mt-1" id="address_line_three" name="address_line_three"
                                    placeholder="Address Line Three">

                                    

                                    
                                
                            </div>
                        </div>
                      


                    </div>
                </form>

              

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>




=======
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
                                        <option value="company">Company</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_in_stock">File In Stock</label>
                                    <select name="file_in_stock" id="file_in_stock" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_return">Last Return Submission Year</label>
                                    <input type="number" class="form-control" id="last_return" name="last_return"
                                        placeholder="2021">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_rack">File Rack</label>
                                    <select name="file_rack" id="file_rack" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_line_one">Address</label>
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
                    <button type="button" class="btn btn-primary" id="addBtn">Save changes</button>
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
                    <button type="button" class="btn btn-primary" id="updateBtn">Update changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
@endsection



@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->


    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
<<<<<<< HEAD
                "lengthChange": false,
=======
                "lengthChange": true,
>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
<<<<<<< HEAD
            
        })
=======

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

                            }) ;

                            $('#editModal').modal('hide');
                            $('#edit-tax-payer-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            })
        })


>>>>>>> c8c99453e942ba3b1e698c8c6bacd41c86185225
    </script>
@endpush
