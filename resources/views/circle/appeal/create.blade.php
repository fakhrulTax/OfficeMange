@extends('app')
@section('title',$title)

@push('css')
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Appeal</h1>
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

                <form action="{{ route('circle.appeal.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- Add your form fields here similar to the collection form -->
                        <!-- Example: -->
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="type">Register Type</label>
                                    @error('type')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="">Select Register Type</option>
                                        <option value="appeal">Appeal</option>
                                        <option value="tribunal">Tribunal</option>
                                        <option value="high_court">High Cour</option>
                                        <option value="review">Review</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tin">TIN</label>
                                    @error('tin')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="tin" placeholder="TIN" name="tin"
                                        value="{{ old('tin') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_order">Appeal Order</label>
                                    @error('appeal_order')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_order" placeholder="Appeal Order" name="appeal_order"
                                        value="{{ old('appeal_order') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_order_date">Appeal Order Date</label>
                                    @error('appeal_order')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_order_date" placeholder="Appeal Order Date" name="appeal_order_date"
                                        value="{{ old('appeal_order_date') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_disposal_date">Appeal Disposal Date</label>
                                    @error('appeal_disposal_date')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_disposal_date" placeholder="Appeal Disposal Date" name="appeal_disposal_date"
                                        value="{{ old('appeal_disposal_date') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="assessment_year">Assessment Year</label>
                                    @error('assessment_year')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="assessment_year" placeholder="202212022" name="assessment_year"
                                        value="{{ old('assessment_year') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="main_income">Main Income</label>
                                    @error('main_income')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="main_income" placeholder="Main Income" name="main_income"
                                        value="{{ old('main_income') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="main_tax">Main Tax</label>
                                    @error('main_tax')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="main_tax" placeholder="Main Tax" name="main_tax"
                                        value="{{ old('main_tax') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="arrear_type">Arrear Type</label>
                                    @error('arrear_type')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <select class="form-control" name="arrear_type" id="arrear_type" required>
                                        <option value="">Select Arrear Type</option>
                                        <option value="tax">Regular Tax</option>
                                        <option value="fine">Fine</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="revise_income">Revise Income</label>
                                    @error('revise_income')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="revise_income" placeholder="Revise Income" name="revise_income"
                                        value="{{ old('revise_income') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="revise_tax">Revise Tax</label>
                                    @error('revise_tax')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="revise_tax" placeholder="Revise Tax" name="revise_tax"
                                        value="{{ old('revise_tax') }}" required>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            
            </div>            
            <!----- card-body -->
        </div>
        <!-- /.card -->

    </section>


    
@endsection



@push('js')
   
    <script>
        



    </script>
@endpush