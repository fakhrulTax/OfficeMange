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
            
        </div>

    </div>



    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4 ">
                    <div class="card bg-success">
                        <div class="card-body">
                            <h5>Disputed Arrear: {{ $Helper::moneyFormatBD($sumDisputedArrear) }}</h5>
                            <h5 style="border-bottom: 1px solid #eee">Undisputed Arrear: {{ $Helper::moneyFormatBD($sumUndisputedArrear) }}</h5>
                            <h5>Total Arrear: {{ $Helper::moneyFormatBD($sumDisputedArrear + $sumUndisputedArrear) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <h5>Total Arrear: {{ $Helper::moneyFormatBD($sumDisputedArrear + $sumUndisputedArrear) }}</h5>
                            <h5 style="border-bottom: 1px solid #eee">Total Collection: {{ $Helper::moneyFormatBD($arrearCollection) }}</h5>
                            <h5>Net Arrear: {{ $Helper::moneyFormatBD(($sumDisputedArrear + $sumUndisputedArrear) - $arrearCollection) }}</h5>
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
                                    <th>Circle</th>
                                    <th>Total Taxpayer</th>
                                    <th>Disputed Arrear</th>
                                    <th>Undisputted Arrear</th>
                                    <th>Total Arrear</th>
                                    <th>Collection</th>
                                </tr>
                            </thead>

                            <tbody>   

                            @php
                                $sumTaxPayers = 0;
                                $sumDisputedArrear = 0;
                                $sumUndisputedArrear = 0;
                                $sumCollection = 0;
                            @endphp

                            @foreach($circles as $circle)

                                @php
                                    $disputedArrear = $aModel::getSumArrearByType('disputed',[$circle]);
                                    $undisputedArrear = $aModel::getSumArrearByType('undisputed',[$circle]);
                                    $circleCollection = $cModel::arrearCollectionByCircles([$circle]);
                                    $taxPayers = $aModel::sumArrearTaxPayers( $circle );

                                    $sumTaxPayers += $taxPayers;
                                    $sumDisputedArrear += $disputedArrear;
                                    $sumUndisputedArrear += $undisputedArrear;
                                    $sumCollection += $circleCollection;
                                @endphp

                                <tr>
                                    <td><a href="{{ route('range.arrear.circle', $circle) }}">Circle-{{ $circle }}</a></td>
                                    <td class="text-right">{{ $Helper::moneyFormatBD($taxPayers) }}</td>
                                    <td class="text-right">{{ $Helper::moneyFormatBD($disputedArrear) }}</td>
                                    <td class="text-right">{{ $Helper::moneyFormatBD($undisputedArrear) }}</td>
                                    <td class="text-right">{{ $Helper::moneyFormatBD($disputedArrear + $undisputedArrear) }}</td>
                                    <td class="text-right">{{ $Helper::moneyFormatBD($circleCollection) }}</td>
                                </tr>

                            @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-right">{{ $Helper::moneyFormatBD($sumTaxPayers) }}</th>
                                    <th class="text-right">{{ $Helper::moneyFormatBD($sumDisputedArrear) }}</th>
                                    <th class="text-right">{{ $Helper::moneyFormatBD($sumUndisputedArrear) }}</th>
                                    <th class="text-right">{{ $Helper::moneyFormatBD($sumDisputedArrear + $sumUndisputedArrear) }}</th>
                                    <th class="text-right">{{ $Helper::moneyFormatBD($sumCollection) }}</th>
                                </tr>
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
        $(function() {
            $("#example1").DataTable({
                order:[[1, 'ASC']],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],                

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        });
    </script>
@endpush
