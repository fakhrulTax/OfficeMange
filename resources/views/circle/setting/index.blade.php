@extends('app')
@section('title',$title)

@push('css')
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
                        <a class="nav-link" id="vert-tabs-order-tab" data-toggle="pill" href="#vert-tabs-order" role="tab" aria-controls="vert-tabs-order" aria-selected="false">Order Sheet</a>

                      </div>
                    </div>
                    <div class="col-9 col-sm-9">
                      <div class="tab-content" id="vert-tabs-tabContent">

                        @include('circle.Setting.general') 

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
  
  <script>
      $(function () {
        // Summernote
        $('.summernote').summernote()
      })
  </script>
@endpush