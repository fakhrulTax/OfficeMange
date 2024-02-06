@extends('app')

@section('title', $title)

@push('css')
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upazila</h1>
                </div>

                <div class="col-md-6">                    
                </div>
              
            </div>
        </div>

    </div>

    <section class="content">

        <div class="card">
            <div class="card-body">
            
            @if(isset($updateType)  && $updateType == 'edit')

            <form class="form" action="{{ route('commissioner.tds.upazila.update', $updateUpazila->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-4">
                        <!-- Upazila Name -->
                        <div class="form-group">
                            <label for="name">Upazila Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Upazila Name" value="{{ $updateUpazila->name }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Zilla ID -->
                        <div class="form-group">
                            <label for="zilla_id">Zilla Name</label>
                            <select name="zilla_id" class="form-control" id="zilla_id" required>
                                <option value="">Select Zilla</option>
                                @foreach($zillas as $zilla)
                                    <option value="{{ $zilla->id }}" {{ ( $updateUpazila->zilla_id == $zilla->id ) ? 'selected' : '' }}>{{ ucfirst($zilla->name) }}</option>
                                @endforeach
                            </select>
                            @error('zilla_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-danger">Update Upazila</button>
                    </div>

                </div>

            </form>

            @else
            <form class="form" action="{{ route('commissioner.tds.upazila.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-4">
                        <!-- Upazila Name -->
                        <div class="form-group">
                            <label for="name">Upazila Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Upazila Name" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Zilla ID -->
                        <div class="form-group">
                            <label for="zilla_id">Zilla Name</label>
                            <select name="zilla_id" class="form-control" id="zilla_id" required>
                                <option value="">Select Zilla</option>
                                @foreach($zillas as $zilla)
                                    <option value="{{ $zilla->id }}">{{ ucfirst($zilla->name) }}</option>
                                @endforeach
                            </select>
                            @error('zilla_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary">Create Upazila</button>
                    </div>

                </div>

            </form>
            @endif
            </div>
        </div>

        <div class="card">

            @if (count($zillas) < 1)
                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">

                        @foreach( $zillas as $zilla )
                        @php
                            $upazilas = $zilla->upazilas;
                        @endphp
                        <div class="col-md-4">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h6>{{ $zilla->name }} ({{ count($upazilas) }})</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>

                                            @foreach($upazilas as $upazila)
                                            <tr>
                                                <td>{{ $upazila->name }}</td>
                                                <td><a href="{{ route('commissioner.tds.upazila.edit', $upazila->id) }}" class="btn btn-sm btn-secondary">Edit</a></td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                </div>
            @endif

        </div>
        <!-- /.card -->

    </section>



@endsection



@push('js')
    <script>

    </script>
@endpush
