@extends('app')

@section('title', 'TDS')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TDS</h1>
                </div>

                <div class="col-md-6">

                </div>

            </div>
        </div>

    </div>

    <section class="content">



        <div class="card">
            <div class="card-body">
                <form action="{{ route('commissioner.tdsList.search') }}" method="GET">
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="zilla">Zilla</label>
                                <select class="form-control" name="zilla_search" id="zilla_search">
                                    <option value="">Select Zilla</option>
                                    @foreach ($zillas as $zilla)
                                        <option value="{{ $zilla->id }}">{{ ucfirst($zilla->name) }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="upazila_search">Upazilla</label>
                                <select class="form-control" name="upazila_search" id="upazila_search">
                                    <option value="">Select Upazilla</option>

                                </select>
                            </div>
                        </div>



                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="organization_search">Organization</label>
                                <select class="form-control" name="organization_search" id="organization_search">
                                    <option value="">Select Organization</option>


                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="circle">Circle</label>
                                <select class="form-control" name="circle" id="circle">
                                    <option value="">Select Circle</option>

                                    @for ($circle = 1; $circle <= 22; $circle++)
                                        <option value="{{ $circle }}"
                                            @if (!empty($search->circle) && $search->circle == $circle) {{ 'selected' }} @endif> Circle
                                            {{ $circle }}</option>
                                    @endfor

                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="start_month">Start Month</label>
                                <input type="month" name="start_month" class="form-control">

                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="end_month">End Month</label>
                                <input type="month" name="end_month" class="form-control">

                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group mt-4">
                                <input type="submit" class="btn btn-primary mt-2" value="Search">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>





        <div class="card">

            @if (count($tdsList) < 1)

                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="movement_table" class="table  table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Collection Month </th>
                                <th>Zilla</th>
                                <th>Upazila</th>
                                <th>Orginization</th>
                                <th>Circle</th>
                                <th>TDS</th>
                                <th>Bill</th>

                                <th>Comments</th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($tdsList as $key => $tds)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        {{ date('M-Y', strtotime($tds->collection_month)) }}<br>

                                    </td>
                                    <td> {{ ucfirst($tds->upazila->zilla->name) }}</td>
                                    <td> {{ ucfirst($tds->upazila->name) }}</td>
                                    <td> {{ ucfirst($tds->organization->name) }} </td>
                                    <td> Circle-{{ $tds->circle }} </td>
                                    <td>
                                        {{ App\Helpers\MyHelper::moneyFormatBD($tds->tds) }}
                                    </td>
                                    <td> {{ App\Helpers\MyHelper::moneyFormatBD($tds->bill) }} </td>

                                    <td> {{ $tds->comments }} </td>


                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="font-weight-bold text-center">Total</td>
                                <td>{{ App\Helpers\MyHelper::moneyFormatBD($tds->sum('tds')) }}</td>
                                <td>{{ App\Helpers\MyHelper::moneyFormatBD($tds->sum('bill')) }}</td>
                                <td></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->


            @endif

        </div>
        <!-- /.card -->

        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {{ $tdsList->links('pagination::bootstrap-4') }}
            </ul>
        </div>



    </section>




@endsection

@push('js')
    <script>
        $('#zilla_search').change(function() {
            var zilla = $(this).val();
            $('#upazila_search').empty();
            if (zilla) {

                $.ajax({
                    type: "GET",
                    url: "{{ url('upazilla') }}/" + zilla,
                    dataType: "json",

                    success: function(res) {
                        if (res) {



                            $('#upazila_search').append('<option value="">Select Upazilla</option>');
                            $.each(res.upazilla, function(key, value) {
                                $('#upazila_search').append('<option value="' + value.id +
                                    '">' + value
                                    .name + '</option>').css("text-transform", "capitalize");
                            });

                        }
                    }



                });
            }


        });

        $('#upazila_search').change(function() {
            var upazila = $(this).val();

            if (upazila) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ogranization') }}/" + upazila,
                    dataType: "json",

                    success: function(res) {
                        if (res) {

                            $('#organization_search').empty();

                            $('#organization_search').append(
                                '<option value="">Select Organization</option>');
                            $.each(res.organization, function(key, value) {

                                $.each(value.organizations, function(key, org) {

                                    $('#organization_search').append('<option value="' +
                                        org
                                        .id + '">' + org.name + '</option>').css(
                                        "text-transform", "capitalize");
                                })

                            });

                        }
                    }

                })
            }

        });
    </script>
@endpush
