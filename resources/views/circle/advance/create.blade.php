@extends('app')

@section('title','Add Advance')

@push('css')
@endpush


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Advance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">


            <form action="{{ route('circle.advance.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                              <label for="advance_assessment_year">Advance Assessment Year</label>
                           
                              <input type="nubmer" class="form-control" id="advance_assessment_year" placeholder="Assessment Year" name="advance_assessment_year" value="{{ config('settings.assessment_year_'.Auth::user()->circle) + 10001 }}" readonly>
                              @error('advance_assessment_year')
                              <div class="text text-danger">{{ $message }}</div>
                            @enderror
                           </div>
                          </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                              <label for="tin">TIN</label>
                             
                              <input type="nubmer" class="form-control" id="tin" placeholder="TIN" name="tin" value="{{ old('tin') }}" required>
                              @error('tin')
                              <div class="text text-danger">{{ $message }}</div>
                            @enderror
                           </div>
                        </div>

                       

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="return_submitted_assessment_year">Last Assessment Year</label>
                             
                              <input type="nubmer" class="form-control" id="return_submitted_assessment_year" placeholder="Assessment Year" name="return_submitted_assessment_year" value="{{ old('return_submitted_assessment_year') }}" required>
                              @error('return_submitted_assessment_year')
                              <div class="text text-danger">{{ $message }}</div>
                            @enderror
                           </div>
                          </div>


                    

                

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="income">Income</label>
                         
                          <input type="number" class="form-control" id="income" placeholder="Income" name="income" value="{{ old('income') }}" required>
                          @error('income')
                          <div class="text text-danger">{{ $message }}</div>
                        @enderror
                       </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="tax">Tax</label>
                       
                          <input type="number" class="form-control" id="tax" placeholder="Tax" name="tax" value="{{ old('tax') }}" required>
                          @error('tax')
                          <div class="text text-danger">{{ $message }}</div>
                        @enderror
                       </div>
                      </div>

                     
                <!-- /.card-body -->
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                <div class="col-sm-12">
              </form>
                


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>


    
@endsection

