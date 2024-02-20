@extends('app')

@section('title', $title)

@push('css')
<style>
    /* Remove default bullets */
    ul, #myUL {
        list-style-type: none;
        padding: 0;
    }

    /* Style the caret/arrow */
    .caret {
        cursor: pointer;
        user-select: none; /* Prevent text selection */
        display: flex;
        align-items: center;
    }

    /* Create the caret/arrow with a unicode, and style it */
    .caret::before {
        content: "\25B6";
        color: #555;
        display: inline-block;
        margin-right: 6px;
    }

    /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
    .caret-down::before {
        transform: rotate(90deg);
    }

    /* Hide the nested list */
    .nested {
        display: none;
        margin-left: 20px; /* Left margin for child elements */
    }

    /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
    .active {
        display: block;
    }
    .nested .active a {
        color: red;
    }

    /* Stylish border for the tree */
    #myUL {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }

    /* Stylish border for each list item */
    li {
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }

    /* Remove border from the last list item */
    li:last-child {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upazila & Organization</h1>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <section class="content">
        
        <div class="card">
           <div class="card-body">
                <form action="{{ route('circle.tds.organization.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="zilla_search" id="zilla_search" required>
                                    <option value="">Select Zilla</option>
                                    @foreach ($zillas as $zilla)
                                        <option value="{{ $zilla->id }}" {{ ($zilla->id == $circleZillaId) ? 'selected' : '' }}>{{ ucfirst($zilla->name) }}</option>
                                    @endforeach            
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="upazila_search" id="upazila_search" required>
                                    <option value="">Select Upazilla</option>                                    
                                    @foreach( $circleUpazilas as $upazila )
                                        <option value="{{ $upazila->id }}">{{ $upazila->name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <!-- Organization Type -->
                            <div class="form-group">
                                <select name="is_govt" id="is_govt" class="form-control" requi  red>
                                    <option value="">Select Type</option>
                                    <option value="1" >Govt.</option>
                                    <option value="0" >Non Govt.</option>
                                </select>
                                @error('is_govt') 
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Organization Name" required>
                            </div>                            
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Add Organization</button>
                        </div>


                    </div>
                </form>
           </div>
        </div>

        <div class="card">
            @if (count($zillas) < 1)
                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <h5 class="card-header">Upazila</h5>
                                <div class="card-body">
                                    <ul id="myUL">
                                    @foreach($zillas as $zilla)
                                        <li>
                                            @if(isset($selectedUpazila))
                                                <span class="caret {{ in_array($selectedUpazila->id, $zilla->upazilas->pluck('id')->toArray()) ? 'caret-down' : '' }}">
                                            @else
                                                <span class="caret">
                                            @endif
                                                {{ ucfirst($zilla->name) }}                                          
                                            </span>

                                            @if(isset($selectedUpazila))
                                                <ul class="nested {{ in_array($selectedUpazila->id, $zilla->upazilas->pluck('id')->toArray()) ? 'active' : '' }}">
                                            @else
                                            <ul class="nested">
                                            @endif
                                                @foreach($zilla->upazilas as $upazila)
                                                    @php
                                                        if( !in_array($upazila->id, $circleUpazilasIds)  ){
                                                            continue;
                                                        }
                                                    @endphp
                                                       
                                                    <li class="{{ (isset($selectedUpazila) && $selectedUpazila->id == $upazila->id) ? 'active' : '' }}">
                                                        <a href="{{ route('circle.tds.upazilaSelected.organization', $upazila->id) }}">
                                                            {{ ucfirst($upazila->name) }}
                                                        </a>
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4" style="max-height: 800px; overflow-y:scroll">
                            <div class="card">
                                <h5 class="card-header">Selected Organization</h5>
                                <div class="card-body">
                                    <ul class="organization-list">

                                        @if(isset($selectedUpazila))
                                            @foreach($selectedUpazila->organizations as $key => $organization)
                                                <li class="organization-list-item">
                                                    {{ ++$key.'. '. $organization->name }}

                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4" style="max-height: 800px; overflow-y:scroll">
                            <div class="card">
                                <h5 class="card-header">Organization List</h5>
                                <div class="card-body">
                                    @if(isset($selectedUpazila))
                                    <form class="multiple-select-form" method="post" action="{{ route('circle.tds.upazilaSelected.addOrganizations', ['upazilaId' => $selectedUpazila->id]) }}">
                                    @else 
                                    <form class="multiple-select-form" method="post" action="{{ route('circle.tds.upazilaSelected.addOrganizations', false) }}">
                                    @endif
                                        @csrf
                                        <div class="form-group">
                                            @foreach($organizations as $key => $organization)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="selected_organizations[]" value="{{ $organization->id }}" id="organization{{ $organization->id }}">
                                                    <label class="form-check-label" for="organization{{ $organization->id }}">
                                                        {{ ++$key.'. '.ucfirst($organization->name) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if(isset($selectedUpazila))
                                        <button type="submit" class="btn btn-primary">Add Selected Organizations</button>
                                        @else 
                                        <button type="submit" class="btn btn-primary" disabled>Select Upazila First</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer"></div>
            @endif
        </div>
        <!-- /.card -->
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
                                $('#upazila_search').append('<option value="' + value.id + '">' + value
                                    .name + '</option>').css("text-transform", "capitalize");
                            });

                        }
                    }



                });
            }

        });


        document.addEventListener('DOMContentLoaded', function() {
            var toggler = document.getElementsByClassName("caret");

            for (var i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function() {
                    // Close all other active lists
                    var siblings = this.parentElement.parentElement.children;
                    for (var j = 0; j < siblings.length; j++) {
                        if (siblings[j] !== this.parentElement) {
                            siblings[j].querySelector(".nested").classList.remove("active");
                            siblings[j].querySelector(".caret").classList.remove("caret-down");
                        }
                    }

                    // Toggle the current list
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
            }
        });
        
    </script>
@endpush
