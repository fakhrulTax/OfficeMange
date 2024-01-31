@extends('app')
@section('title',$title)

@push('css')
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Appeal</h1>
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

                <form action="{{ route('circle.appeal.update', $appeal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                                        <option value="appeal" {{ ($appeal->type == 'appeal') ? 'selected' : '' }}>Appeal</option>
                                        <option value="tribunal" {{ ($appeal->type == 'tribunal') ? 'selected' : '' }}>Tribunal</option>
                                        <option value="high_court"{{ ($appeal->type == 'high_court') ? 'selected' : '' }}>High Cour</option>
                                        <option value="review" {{ ($appeal->type == 'review') ? 'selected' : '' }}>Review</option>
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
                                        value="{{ $appeal->tin }}" required readOnly>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_order">Appeal Order</label>
                                    @error('appeal_order')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_order" placeholder="Appeal Order" name="appeal_order"
                                        value="{{ $appeal->appeal_order }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_order_date">Appeal Order Date</label>
                                    @error('appeal_order')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_order_date" placeholder="Appeal Order Date" name="appeal_order_date"
                                        value="{{ date('d-m-Y', strtotime($appeal->appeal_order_date)) }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="appeal_disposal_date">Appeal Disposal Date</label>
                                    @error('appeal_disposal_date')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" class="form-control" id="appeal_disposal_date" placeholder="Appeal Disposal Date" name="appeal_disposal_date"
                                        value="{{ date('d-m-Y', strtotime($appeal->appeal_disposal_date)) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="assessment_year">Assessment Year</label>
                                    @error('assessment_year')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="assessment_year" placeholder="202212022" name="assessment_year"
                                        value="{{ $appeal->assessment_year }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="main_income">Main Income</label>
                                    @error('main_income')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="main_income" placeholder="Main Income" name="main_income"
                                        value="{{ $appeal->main_income }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="main_tax">Main Tax</label>
                                    @error('main_tax')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="main_tax" placeholder="Main Tax" name="main_tax"
                                        value="{{ $appeal->main_tax }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="arrear_type">Arrear Type</label>
                                    @error('arrear_type')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <select class="form-control" name="tax_type" id="tax_type" required readOnly>
                                        <option value="">Select Arrear Type</option>
                                        <option value="tax" {{ ($appeal->tax_type == 'tax') ? 'selected' : '' }}>Regular Tax</option>
                                        <option value="fine" {{ ($appeal->tax_type == 'fine') ? 'selected' : '' }}>Fine</option>
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
                                        value="{{ $appeal->revise_income }}" required>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="revise_tax">Revise Tax</label>
                                    @error('revise_tax')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="number" class="form-control" id="revise_tax" placeholder="Revise Tax" name="revise_tax"
                                        value="{{ $appeal->revise_tax }}" required>
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