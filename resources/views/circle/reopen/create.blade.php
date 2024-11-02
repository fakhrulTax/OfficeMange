@extends('app')



@section('title','Add Reopen')



@push('css')

@endpush


@section('content')

    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0">Add Reopen</h1>

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





            <form action="{{ route('circle.reopen.store') }}" method="POST">
            @csrf

           
                <div class="row">

                  <div class="col-sm-3">
                    <div class="form-group">
                        <label for="tin">TIN</label>
                        <input type="number" class="form-control" id="tin" placeholder="TIN" name="tin" value="{{ old('tin') }}" required>
                        @error('tin')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="assessment_year"> Assessment Year</label>
                            <input type="number" class="form-control" id="assessment_year" placeholder="20242025" name="assessment_year" value="{{ old('assessment_year') }}" >
                            @error('assessment_year')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="reopen_date">Reopen Date</label>
                            <input type="text" class="form-control" id="reopen_date" name="reopen_date" value="{{ old('reopen_date') }}" autocomplete="off" placeholder="01-07-2024" required>
                            @error('reopen_date')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="main_income">Main Income</label>
                            <input type="number" class="form-control" id="main_income" placeholder="main_income" name="main_income" value="{{ old('main_income') }}" required>
                            @error('main_income')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="main_tax">Main Tax</label>
                            <input type="number" class="form-control" id="main_tax" placeholder="Tax" name="main_tax" value="{{ old('main_tax') }}" required>
                            @error('main_tax')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="expire_date">Expire Date</label>
                            <input type="text" class="form-control" id="expire_date" name="expire_date" value="{{ old('expire_date') }}" autocomplete="off" placeholder="30-06-2025" required>
                            @error('expire_date')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="disposal_date">Disposal Date</label>
                            <input type="text" class="form-control" id="disposal_date" name="disposal_date" value="{{ old('disposal_date') }}" autocomplete="off" placeholder="30-06-2025" >
                            @error('disposal_date')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="assessed_income">Assessed Income</label>
                            <input type="number" class="form-control" id="assessed_income" placeholder="Assessed Income" name="assessed_income" value="{{ old('assessed_income') }}">
                            @error('assessed_income')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="demand">Demand</label>
                            <input type="number" class="form-control" id="demand" placeholder="Demand" name="demand" value="{{ old('demand') }}">
                            @error('demand')
                                <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">Add Reopen</button>
                </div>

               
        
            </form>


                





            </div>

            <!-- /.card-body -->

        </div>

        <!-- /.card -->



    </section>





    

@endsection



