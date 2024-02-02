@extends('app')

@section('title', 'Arrear')

@push('css')
    <!--  Datatable -->

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Arrear({{ count($arrears) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#addModal"><i class="fas fa-plus"></i> Add item</button>
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
                            <th>#</th>
                            <th>Name, Address and TIN</th>
                            <th>Assessment Year</th>
                            <th>Arrear</th>
                            <th>Fine</th>
                            <th>Circle</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $i = 0;
                        @endphp

                        @foreach ($arrears as $key => $arrear)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $arrear[0]->stock->name }} <br>
                                    {{ str_replace('</p><p>', ', ', strip_tags($arrear[0]->stock->address)) }} <br>
                                    {{ $arrear[0]->tin }}
                                </td>

                                <td>

                                    <table class="table table-bordered table-striped">
                                        @foreach ($arrear as $key => $ar)
                                            <tr>



                                                <td>{{ App\Helpers\MyHelper::assessment_year_format($ar->assessment_year) }}
                                                </td>

                                                <td>{{ $ar->arrear_type }}</td>
                                                <td class="text-right">
                                                    {{ App\Helpers\MyHelper::moneyFormatBD($ar->arrear) }}</td>



                                                <td class="text-right">

                                                    <button class="btn btn-danger btn-sm "
                                                        onclick="ArreardEdit({{ $ar->id }})" data-toggle="modal"
                                                        data-target="#editModal">Edit</button>
                                                </td>





                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-bold">Total</td>
                                            <td></td>
                                            <td class="text-bold text-right">
                                                {{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('arrear')) }}</td>
                                            <td></td>

                                        </tr>


                                    </table>

                                </td>

                                <td class="text-right">
                                    {{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('arrear')) }}
                                </td>

                                <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('fine')) }}</td>

                                <td>Circle-{{ $arrear[0]->circle }}</td>
                                <td>Notice</td>


                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach





                    </tbody>
                    <tfoot>
                        <th colspan="3" class="text-center">Total</th>


                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th colspan="2"></th>

                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->




        {{-- add Modal start  --}}

        <div class="modal fade" id="addModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Arrear</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-12">
                            <h4 class="text-danger error">

                            </h4>
                        </div>

                        <form action="" method="POST" id="add-arrear-form">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="arrear_type"> Arrear Type</label>
                                        <select name="arrear_type" id="arrear_type" class="form-control">
                                            <option selected disabled>Select Arrear Type</option>
                                            <option value="disputed">Disputed</option>
                                            <option value="undisputed">UnDisputed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tin">TIN Number</label>
                                        <input type="number" class="form-control text-danger" id="tin" name="tin"
                                            placeholder="6540656206">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="demand_create_date"> Demand Create Date </label>
                                        <input type="date" class="form-control" id="demand_create_date"
                                            name="demand_create_date">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assessment_year">Assesment Year</label>
                                        <input type="number" class="form-control" id="assessment_year"
                                            name="assessment_year" placeholder="20212022">
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="arrear"> Arrear</label>
                                        <input type="number" class="form-control" id="arrear" name="arrear"
                                            placeholder="156465">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fine">Fine</label>
                                        <input type="number" class="form-control" id="fine" name="fine"
                                            placeholder="1000">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comments"> Comments </label>
                                        <textarea name="comments" id="comments" cols="30" rows="2" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </form>



                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addBtn" disabled>Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        {{-- Edit Modal Start --}}

        <div class="modal fade" id="editModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit New Arrear</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
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
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }


        $(function() {
            $("#example1").DataTable({

                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

                    // Remove the formatting to get integer data for summation
                    let intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };

                    // Total over all pages
                    total = api
                        .column([3])
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);



                    // Total over this page
                    arrearTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);


                    // Update footer
                    api.column(3).footer().innerHTML = numberWithCommas(arrearTotal);


                    // Fine Total over this page
                    fineTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce((a, b) => intVal(a) + intVal(b), 0);

                    // Update footer
                    api.column(4).footer().innerHTML = numberWithCommas(fineTotal);




                }


            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');




        });



        
    </script>


    <script>
        $(document).ready(function() {

            $('#addBtn').on('click', function() {
                $data = $('#add-arrear-form').serialize();
                $.ajax({
                    url: "{{ route('circle.arrearStore') }}",
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
                            $('#add-arrear-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            });

            function numberWithCommas(x) {
                x = x.toString();
                var pattern = /(-?\d+)(\d{3})/;
                while (pattern.test(x))
                    x = x.replace(pattern, "$1,$2");
                return x;
            }




            $('#tin').keyup(function() {
                var tin = $(this).val();
                if (tin.length == 12) {

                    $.ajax({
                        url: "{{ url('tin-checker') }}" + '/' + tin,
                        type: "GET",
                        data: {
                            tin: tin
                        },
                        success: function(data) {

                            if (data.status == 200) {
                                $('#addBtn').prop('disabled', false);
                                $('#tin').addClass('bg-success');
                                $('#tin').removeClass('bg-danger');;

                            } else {
                                $('#tin').removeClass('bg-success');
                                $('#tin').addClass('bg-danger');
                                $('#addBtn').prop('disabled', true);
                            }

                        }
                    })






                } else {

                    $('#tin').removeClass('bg-success');
                    $('#tin').addClass('bg-danger');
                    $('#addBtn').prop('disabled', true);


                }
            })
        });


        function ArreardEdit(id) {
            $.ajax({
                url: "{{ route('circle.arrearEdit') }}",
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
                $data = $('#edit-arrear-form').serialize();

                $.ajax({
                    url: "{{ route('circle.arrearUpdate') }}",
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
                            $('#edit-arrear-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            })
        })
    </script>
@endpush
