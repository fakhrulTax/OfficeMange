@extends('app')

@section('title','Return|Add')

@push('css')
   
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Entry</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="" class="btn btn-primary float-right"><i class="fas fa-minus"></i> Back To Return</a>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <div class="card-body">

            <!-- Form -->             
            <form action="" method="POST">
            @csrf

                <div class="container">

                    <!-- Start Row -->
                    <div class="row">
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="assessment_year">Assessment Year*</label>
                                <select name="assessment_year" id="assessment_year" class="form-control" required>
                                        @php
                                            $a = config('settings.assessment_year_'.Auth::user()->circle);  
                                        @endphp
                                         
                                        @for($i= 1; $i<=25; $i++)
                                            <option value="{{ $a }}" {{ (old('assessment_year') == $a) ? 'selected' : '' }}>{{ $Helper::assessment_year_format($a) }}</option>
                                            @php
                                                $a = $a-10001;  
                                            @endphp
                                        @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="register">Register*</label>
                                <select name="register" id="register" class="form-control" required>
                                    <option value="a" {{ (old('register') == 'a') ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ (old('register') == 'b') ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ (old('register') == 'c') ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ (old('register') == 'd') ? 'selected' : '' }}>D</option>
                                    <option value="normal" {{ (old('register') == 'normal') ? 'selected' : '' }}>Normal</option>
                                </select>
                                @error('register')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>      
                        
                        <div class="col-md-3">
                            <div class="form-group">                        
                                <label for="return_submission_date">Subimission Date*</label>                                
                                <input type="text" name="return_submission_date" id="return_submission_date" class="form-control" value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy" required>
                                @error('return_submission_date')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="register_serial">Register Serial*</label>                                
                                <input type="number" name="register_serial" id="register_serial" placeholder="Register Serial" class="form-control" value="" required>
                                @error('register_serial')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>  

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tin">TIN*</label>
                                <input type="number" name="tin" id="tin" placeholder="TIN" class="form-control" value="{{ old('tin') }}" onkeyup="getStock()" autofocus required>                            
                                @error('tin')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
                        

                    </div>
                    <!-- End Row -->

                    <!-- Start Row -->
                    <div class="row">                          
                       
                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="source_of_income">Income Source</label>
                                <input type="text" name="source_of_income" id="source_of_income" placeholder="Income Source" class="form-control" value="{{ old('source_of_income') }}">                            
                                @error('source_of_income')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                       </div> 

                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="income">Income*</label>
                                <input type="number" name="income" id="income" placeholder="Income" class="form-control" value="{{ old('income') }}" required>                            
                                @error('income')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                       </div> 

                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="income_of_poltrey_fisheries">Poultry/Fish Income</label>
                                <input type="number" name="income_of_poltrey_fisheries" id="income_of_poltrey_fisheries" placeholder="Poultry/Fish Income" class="form-control" value="{{ old('income_of_poltrey_fisheries') }}">                            
                                @error('income_of_poltrey_fisheries')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                       </div> 

                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="income_of_remitance">Remittance Income</label>
                                <input type="number" name="income_of_remitance" id="income_of_remitance" placeholder="Remittance Income" class="form-control" value="{{ old('income_of_remitance') }}">      

                                @error('income_of_remitance')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                       </div>

                    </div>
                    <!-- End Row -->

                    <!-- Start Row -->
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="source_tax">Source Tax</label>
                                <input type="number" name="source_tax" id="source_tax" placeholder="Source Tax" class="form-control" value="{{ old('source_tax') }}">      

                                @error('source_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div>    

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="advance_tax">Advance Tax</label>
                                <input type="number" name="advance_tax" id="advance_tax" placeholder="Advance Tax" class="form-control" value="{{ old('advance_tax') }}">      

                                @error('advance_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="retarn_tax">Return Tax</label>
                                <input type="number" name="retarn_tax" id="retarn_tax" placeholder="Return Tax" class="form-control" value="{{ old('retarn_tax') }}">      

                                @error('retarn_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="late_fee">Late Fee</label>
                                <input type="number" name="late_fee" id="late_fee" placeholder="Late Fee" class="form-control" value="{{ old('late_fee') }}">      

                                @error('late_fee')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sercharge">Surcharge</label>
                                <input type="number" name="sercharge" id="sercharge" placeholder="Surcharge" class="form-control" value="{{ old('sercharge') }}">      

                                @error('sercharge')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total_tax">Total Tax</label>
                                <input type="number" name="total_tax" id="total_tax" placeholder="Total Tax" class="form-control" value="{{ old('total_tax') }}">      

                                @error('total_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 
                    
                    </div>
                    <!-- End Row -->

                    <!-- Start Row -->
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="liabilities">Liabilities</label>
                                <input type="number" name="liabilities" id="liabilities" placeholder="Liabilities" class="form-control" value="{{ old('liabilities') }}">      

                                @error('liabilities')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="net_asset">Net Asset*</label>
                                <input type="number" name="net_asset" id="net_asset" placeholder="Net Asset" class="form-control" value="{{ old('net_asset') }}" required>      

                                @error('net_asset')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="comments">Comments</label>
                                <input type="text" name="comments" id="comments" placeholder="Comments" class="form-control" value="{{ old('comments') }}">      

                                @error('comments')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                    </div>
                    <!-- End Row -->

                    <!-- Start Row -->
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax_of_schedule_one">Tax of Schedule One</label>
                                <input type="number" name="tax_of_schedule_one" id="tax_of_schedule_one" placeholder="Tax of Schedule One" class="form-control" value="{{ old('tax_of_schedule_one') }}">      

                                @error('tax_of_schedule_one')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="special_tax">Special Tax</label>
                                <input type="number" name="special_tax" id="special_tax" placeholder="Special Tax" class="form-control" value="{{ old('special_tax') }}">      

                                @error('special_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="special_invest">Special Invest</label>
                                <input type="number" name="special_invest" id="special_invest" placeholder="Special Invest" class="form-control" value="{{ old('special_invest') }}">      

                                @error('special_invest')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-3" style="margin-top: 29px">
                            <button type="Submit" class="btn btn-primary"> Add Return</button>
                        </div>

                    </div>
                    <!-- End Row -->

                </div>

            </form>
            
            <!-- EndForm -->

            </div>
            <!-- /.card-body -->


        </div>
        <!-- /.card -->

    </section>


    
@endsection



@push('js')
    <script>     



    </script>
@endpush