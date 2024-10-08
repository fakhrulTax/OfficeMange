@extends('app')

@section('title', 'Arrear')

@push('css')
    <!--  Datatable -->

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

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
                    <h1 class="m-0">Arrear({{ count($arrears) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if( Auth::user()->user_role == 'circle' )
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#addModal"><i class="fas fa-plus"></i> Add Arrear</button>
                        @else
                            <h3 class="text-success">Circle-{{ $circle }}</h3>
                        @endif
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card" style="padding: 10px">

            @if( Auth::user()->user_role == 'circle' )
            <form action="{{ Route('circle.arrears.search') }}" method="GET" class="form">
            @elseif( Auth::user()->user_role == 'range' )
            <form action="{{ Route('range.arrear.circle.search', $circle) }}" method="GET" class="form">
            @elseif( Auth::user()->user_role == 'commissioner' )
            <form action="{{ Route('commissioner.arrear.circle.search', $circle) }}" method="GET" class="form">
            @endif

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="number" id="searchTIN" name="tin" placeholder="TIN" class="form-control"value="{{ Request::get('tin') }}" autofocus>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="arrear_type" id="arrear_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="disputed" {{ (Request::get('arrear_type') == 'disputed') ? 'selected' : '' }}>Disputed</option>
                                    <option value="undisputed" {{ (Request::get('arrear_type') == 'undisputed') ? 'selected' : '' }}>Undisputed</option>
                            </select>
                        </div>
                    </div>
                    

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="from_date" name="from_date" placeholder="From Date" value="{{ Request::get('from_date') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="to_date" name="to_date" placeholder="To Date" value="{{ Request::get('to_date') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>


                </div>
            </form>
        </div>



        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">  
                @if( Auth::user()->user_role == 'circle' )
                    <div>
                        <a href="{{ route('circle.arrears.register') }}" target="_blank" class="btn btn-sm btn-danger">Register</a>
                    </div>
                @endif

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name, Address & TIN</th>
                            <th>Status</th>
                            <th>Assessment Year</th>
                            <th>Arrear</th>
                            <th>Fine</th>
                            <th>Total</th>
                            <th>Collection</th>
                            @if( Auth::user()->user_role == 'circle' )
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                    @php 
                        $i = 0; 
                        $arrearPageTotal = 0;
                        $collectionPageTotal = 0;
                    @endphp

                    @foreach($arrears as $tin => $arrearGroup )
                        
                        @php 
                            $i += 1;                           
                            $countArrear = count($arrearGroup);
                            $printedTIN = false;
                            $arrearSubTotal = 0;
                            $collectionSubTotal = 0;
                        @endphp

                        @foreach( $arrearGroup as $arrear)
                            
                        <tr>                           

                            @if(!$printedTIN)
                                <td rowspan="{{ $countArrear }}">{{ $i }}</td>
                                <td rowspan="{{ $countArrear }}">
                                    {{ $arrear->stock->bangla_name ? $arrear->stock->bangla_name : $arrear->stock->name }}                                    
                                    <div class="address">
                                        {!! $arrear->stock->address !!}
                                    </div>    
                                    {{ $arrear->tin }}                                
                                </td>

                                @php 
                                    $printedTIN = true; 
                                    
                                @endphp

                            @endif

                            @php                                
                                $aCollecntion = App\Models\Collection::getArrearByTINAssessmentYear($arrear->tin, $arrear->assessment_year);
                            @endphp

                            <td>{{ $arrear->arrear_type }}</td>
                            <td>{{ $Helper::assessment_year_format($arrear->assessment_year) }}</td>
                            <td class="text-right">{{ $Helper::moneyFormatBD($arrear->arrear) }}</td>
                            <td class="text-right">{{ $Helper::moneyFormatBD($arrear->fine) }}</td>
                            <td class="text-right">{{ $Helper::moneyFormatBD($arrear->arrear + $arrear->fine) }}</td>
                            <td class="text-right">{{ $Helper::moneyFormatBD($aCollecntion) }}</td>

                            @if( Auth::user()->user_role == 'circle' )
                            <td>
                                <button class="btn btn-danger btn-sm " onclick="ArreardEdit({{ $arrear->id }})" data-toggle="modal" data-target="#editModal">Edit</button>
                                <button class="btn btn-primary btn-sm"  onclick="arrearModal({{ $arrear->tin }})">Notice</button>
                            </td>
                            @endif

                        </tr>  

                        @php
                            $arrearSubTotal += ($arrear->arrear + $arrear->fine);
                            $collectionSubTotal += $aCollecntion;
                            $arrearPageTotal += ($arrear->arrear + $arrear->fine);
                             $collectionPageTotal += $aCollecntion;
                        @endphp

                        @endforeach

                        <tr class="bg-secondary">
                            <td>Sub Total</td>
                            <td colspan="6" class="text-right">{{ $Helper::moneyFormatBD($arrearSubTotal) }}</td>
                            <td class="text-right">{{ $Helper::moneyFormatBD($collectionSubTotal) }}</td>
                        </tr>
                    
                    @endforeach

                    <tr class="bg-danger">
                        <td>Total</td>
                        <td colspan="6" class="text-right">{{ $Helper::moneyFormatBD($arrearPageTotal) }}</td>
                        <td class="text-right">{{$Helper::moneyFormatBD($collectionPageTotal) }}</td>
                    </tr>


                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->


            <div class="card-footer">
                <ul class="pagination pagination-sm m-0 float-right">
                    {{ $arrears->links('pagination::bootstrap-4') }}
                </ul>
            </div>

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

                                        <input type="text" class="form-control" id="demand_create_date"
                                            name="demand_create_date" placeholder="dd-mm-yyyy">

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
                                        <label for="fine">Fine (137)</label>
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
                        <button type="button" class="btn btn-primary" id="addBtn" disabled>Save</button>
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
                        <h4 class="modal-title">Edit Arrear</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateBtn">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>

   <!-- Arrear Modal --> 
    <div class="modal fade" id="arrearModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Arrear Notice </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('circle.arrear.notice') }}" method="POST" target="_blank" >
                @csrf
                <div class="form-group">
                    <input type="hidden" id="atin" name="tin">
                    <label for="issue_date">Issue Date</label>
                    @error('issue_date')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="hearing_date">Hearing Date</label>
                    @error('hearing_date')
                    <div class="text text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" id="hearing_date" name="hearing_date" class="form-control" placeholder="dd-mm-yyyy"  autocomplete="off">
                </div>       
            </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection



@push('js')

    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

    function arrearModal(tin)
    {
        document.getElementById('atin').value = tin;
        $('#arrearModal').modal('toggle');
    }

        
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

            $('#tin').on('input', function() {
               
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
