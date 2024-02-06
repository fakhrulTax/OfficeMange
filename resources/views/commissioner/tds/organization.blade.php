@extends('app')

@section('title', $title)

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

            <form class="form" action="{{ route('commissioner.tds.organization.update', $updateOrganization) }}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <!-- Organization Name -->
                        <div class="form-group">
                            <label for="name">Organization Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Organization Name" value="{{ $updateOrganization->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Organization Type -->
                        <div class="form-group">
                            <label for="is_govt">Organization Type</label>
                            <select name="is_govt" id="is_govt" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="1" {{ ( $updateOrganization->is_govt == 1 ) ? 'selected' : '' }}>Govt.</option>
                                <option value="0" {{ ( $updateOrganization->is_govt == 0 ) ? 'selected' : '' }}>Non Govt.</option>
                            </select>
                            @error('is_govt') 
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary">Create Organization</button>
                    </div>
                </div>
            </form>

            @else
            <form class="form" action="{{ route('commissioner.tds.organization.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <!-- Organization Name -->
                        <div class="form-group">
                            <label for="name">Organization Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Organization Name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Organization Type -->
                        <div class="form-group">
                            <label for="is_govt">Organization Type</label>
                            <select name="is_govt" id="is_govt" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="1">Govt.</option>
                                <option value="0">Non Govt.</option>
                            </select>
                            @error('is_govt') 
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-primary">Create Organization</button>
                    </div>
                </div>
            </form>

            @endif
            </div>
        </div>

        <div class="card">

            @if (count($organizations) < 1)
                <h2 class="text-danger p-5">Sorry! There is no data to show!</h2>
            @else
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="movement_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Organization Name</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($organizations as $key => $organization)
                        <tr>
                            <td>{{ ++$key }}</td>  
                            <td> {{ ucfirst($organization->name) }} </td>
                            <td> <a href="{{ route('commissioner.tds.organization.edit', $organization->id) }}" class="btn btn-sm btn-default">Edit</a></td>
                        </tr>
                        @endforeach

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
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

    <script>     
            $(document).ready(function() {

                $(function() {
            $("#movement_table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#movement_table_wrapper .col-md-6:eq(0)');
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
               

            });
    

    </script>
@endpush
