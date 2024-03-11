@extends('app')
@section('title', 'TDS Create')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if(isset($updateType)  && $updateType == 'edit')

                    <h1 class="m-0">Edit TDS</h1>
                @else
                <h1 class="m-0">Add New TDS</h1>
                @endif
            </div>

            <div class="col-md-6">
            </div>

        </div>
    </div>

</div>

<div class="card">
    <div class="card-body">

      @if(isset($updateType)  && $updateType == 'edit')
      <form action="{{ route('circle.tds.update', $editTds->id) }}" method="POST" >
        @csrf
       
        @if($clickedRoute)
            <input type="hidden" name="clicked_route" value=" {{ $clickedRoute ? $clickedRoute : '' }} ">
            <input type="hidden" name="zilla_id" value="{{ $editTds->upazila->zilla->id }}" class="form-control">
            <input type="hidden" name = "upazila_id" value="{{ $editTds->upazila->id }}" class="form-control">
        @endif
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label for="zilla">Zilla</label>
                   <input type="text" value="{{ ucfirst($editTds->upazila->zilla->name) }}" class="form-control" readonly>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="upazila">Upazilla</label>
                    <input type="text" value="{{ ucfirst($editTds->upazila->name ) }}" class="form-control" readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="organization">Organization</label>
                    <input type="text" value="{{ ucfirst($editTds->organization->name) }}" class="form-control" readonly>
                </div>
            </div>




            <div class="col-md-4">

                <div class="form-group">
                    <label for="collection_month">Collection Month</label>
                    <input type="text" name="collection_month" id="collection_month"
                        placeholder="01-2024" value="{{ date('m-Y', strtotime($editTds->collection_month)) }}" class="form-control">
                </div>
            </div>       


            <div class="col-md-4">
                <div class="form-group">
                    <label for="tds">TDS</label>
                    <input type="number" id="tds" name="tds" placeholder="TDS" class="form-control"
                        value="{{ $editTds->tds }}">
                </div>
            </div>

            <div class="col-md-4">

                <div class="form-group">
                    <label for="bill">Bill</label>
                    <input type="number" value="{{ $editTds->bill }}"  name="bill" placeholder="bill" class="form-control">
                </div>
            </div>


            <div class="col-md-4">
                <label for="comments">Comment</label>
                <div class="form-group">
                    <textarea name="comments" id="" cols="30" rows="1" class="form-control">{{ $editTds->comments }}</textarea>
                </div>
            </div>

            <div class="col-md-3 mt-4">
                <input type="submit" value="Update TDS" class="btn btn-primary  mt-2">

            </div>

        </div>

    </form>



      @else
        <form action="{{ route('circle.tds.store') }}" method="POST">
            @csrf
            

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="zilla">Zilla</label>
                        <select class="form-control" id="zilla" name="zilla_id" required>
                            <option value="">Select Zilla</option>
                            @foreach ($zillas as $zilla)
                                <option value="{{ $zilla->id }}" {{ old('zilla_id') == $zilla->id || $zilla->id == $selectedDistictId ? 'selected' : ''}} >{{ ucfirst($zilla->name) }}</option>
                            @endforeach

                        </select>

                        @error('zilla_id')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            
                        @enderror

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="upazila">Upazilla</label>
                        <select class="form-control" name="upazila_id" id="upazila" required autofocus>
                            <option value="">Select Upazilla</option>

                            @foreach( $selectedUpazilas as $upazila )
                                <option value="{{ $upazila->id }}">{{ ucfirst($upazila->name) }}</option>
                            @endforeach

                        </select>

                        @error('upazila_id')
                        <span class="text-danger" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                            
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="organization">Organization</label>
                        <select class="form-control" name="organization_id" id="organization" required>
                            <option value="">Select Organization</option>


                        </select>

                        @error('organization_id')
                        <span class="text-danger" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                            
                        @enderror
                    </div>
                </div>




                <div class="col-md-4">

                    <div class="form-group">
                        <label for="collection_month">Collection Month</label>
                        <input type="text" id="collection_month" name="collection_month" 
                            placeholder="01-2024" class="form-control" value="{{ old('collection_month') }}" required autocomplete="off">

                            @error('collection_month')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tds">TDS</label>
                        <input type="number" id="tds" name="tds" placeholder="TDS" class="form-control">
                            @error('tds')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label for="bill">Bill</label>
                        <input type="number" id="bill" name="bill" placeholder="bill" class="form-control" value="{{ old('bill') }}">

                            @error('bill')
                            <span class="text-danger" role="alert">
                                <strong> {{ $message }}</strong>
                            </span>
                                
                            @enderror
                    </div>
                </div>



              

                <div class="col-md-4">
                    <label for="comments">Comment</label>
                    <div class="form-group">
             <textarea name="comments" id="" cols="30" rows="1" class="form-control">{{old('comments')}}</textarea>
                    </div>

                    @error('comments')
                    <span class="text-danger" role="alert">
                        <strong> {{ $message }}</strong>
                    </span>
                        
                    @enderror
                </div>

                <div class="col-md-4 mt-4">
                    <input type="submit" value="Add TDS" class="btn btn-primary mt-2">

                </div>

            </div>

        </form>
      @endif
    </div>
</div>



@endsection


@push('js')

<script>
     $('#zilla').change(function() {
            var zilla = $(this).val();
            $('#upazila').empty();

            if (zilla) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('upazilla') }}/" + zilla,
                    dataType: "json",

                    success: function(res) {
                        if (res) {
                            $('#upazila').empty();


                            $('#upazila').append('<option>Select Upazilla</option>');
                            $.each(res.upazilla, function(key, value) {
                                $('#upazila').append('<option value="' + value.id + '">' + value
                                    .name + '</option>').css("text-transform", "capitalize");
                            });

                        }
                    }



                });
            }


        });

        $('#upazila').change(function() {
            var upazila = $(this).val();

            if (upazila) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ogranization') }}/" + upazila,
                    dataType: "json",

                    success: function(res) {
                        if (res) {

                            $('#organization').empty();

                            $('#organization').append('<option>Select Organization</option>');
                            $.each(res.organization, function(key, value) {

                                $.each(value.organizations, function(key, org) {

                                    $('#organization').append('<option value="' + org
                                        .id + '">' + org.name + '</option>').css("text-transform", "capitalize");
                                })

                            });

                        }
                    }

                })
            }

        });



</script>
    
@endpush