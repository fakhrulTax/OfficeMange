@extends('app')
@section('title',$title)

@push('css')
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <form action="{{ route('circle.setting.update') }}" method="POST">
              @csrf
              <div class="card card-primary card-outline " style="margin-top: 15px">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-cogs"></i>
                    Settings
                  </h3>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-3 col-sm-3">
                      <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">

                        <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-general" aria-selected="true">General</a>
                        <a class="nav-link" id="vert-tabs-tds-tab" data-toggle="pill" href="#vert-tabs-tds" role="tab" aria-controls="vert-tabs-tds" aria-selected="false">TDS</a>

                      </div>
                    </div>
                    <div class="col-9 col-sm-9">
                      <div class="tab-content" id="vert-tabs-tabContent">

                        @include('circle.setting.general') 
                        @include('circle.setting.tds') 

                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                </div>
            <!-- /.card -->

              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->


    
@endsection



@push('js')

  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <script>

      $(function () {
        // Summernote
        $('.summernote').summernote()
      })

      $(document).ready(function() {
          $('#upazila').select2();
      });

     $('#zilla').change(function() {
          console.log('go');
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
  </script>
@endpush