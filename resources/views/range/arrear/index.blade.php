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
               




                <div class="col-sm-4">
                    <form action="{{ route('range.arrearssort') }}" id="circle-form" method="POST">
                        @csrf
                      
                      @php
                        $rangeWiseCircle = App\Helpers\MyHelper::rangWiseCircle(Auth::user()->range);
                        
                    @endphp

                        <div class="form-group">
                            <label for="demand_create_date"> Select Circle </label>
                            <select name="circle" id="circle" class="form-control">
                                <option value="all" {{ $circle == 'all' ? 'selected' : '' }}> All </option>
                               
                                @foreach ( $rangeWiseCircle as $circleNo )
                                     <option value="{{ $circleNo }}" {{ $circle == $circleNo ? 'selected' : '' }}> Circle
                                        {{ $circleNo }}</option>
                                @endforeach
                                   
                              
    
    
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>



    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4 ">
                    <div class="card bg-success">
                        <div class="card-body">
                            <h3>Arrear: <span class="arrear">{{ $GrandArrear }}</span> Tk</h3>
                            <h4>Disputed : <span class="disputed">{{ $TotalDisputedArrear }}</span> Tk</h4>
                            <h4>UnDisputed: <span class="undisputed">{{ $TotalUndisputedArrear }}</span> Tk</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <h4 class="disCollection">Collection: </h4>
                            <h4 class="undisCollection">UnDisputed Collection: </h4>
                            <h4 class="undisCollection">UnDisputed Collection: </h4>

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



                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2" class="text-bold text-center">Total</td>


                                                    <td class="text-bold text-right">
                                                        {{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('arrear')) }}
                                                    </td>
                                                    <td></td>
                                                </tr>


                                            </table>

                                        </td>

                                        <td class="text-right">
                                            {{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('arrear')) }}
                                        </td>

                                        <td class="text-right">
                                            {{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('fine')) }}</td>

                                        <td>Circle-{{ $arrear[0]->circle }}</td>



                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach





                            </tbody>
                            <tfoot>
                                <th colspan="3" class="text-center">Total</th>


                                <th></th>
                                <th class="text-right"> </th>
                                <th class="text-right"></th>

                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



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
        $(document).ready(function() {

            // change function for circle
            $('#circle').change(function() {
                let circle = $(this).val();

                $('#circle-form').submit();


            });



        });


        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    <script>
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
@endpush
