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
                        <a href="{{ route('circle.return.index') }}" class="btn btn-primary float-right"><i class="fas fa-minus"></i> Back To Return</a>
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <div class="card-body">

            <!-- Form -->             
            <form method="POST" action="{{ route('circle.return.store') }}">
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

                                        <option value="">Ass. Year</option>
                                        @for($i= 1; $i<=25; $i++)

                                            <option value="{{ $a }}" {{ (session('last_assessment_year') == $a || old('assessment_year') == $a) ? 'selected' : '' }}>{{ $Helper::assessment_year_format($a) }}</option>

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
                                <select name="register" id="register" class="form-control" onchange="getRegisterSerial()" required>
                                    <option value="">Register</option>
                                    <option value="a" {{ (session('last_register') == 'a' || old('register') == 'a') ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ (session('last_register') == 'b' || old('register') == 'b') ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ (session('last_register') == 'c' || old('register') == 'c') ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ (session('last_register') == 'd' || old('register') == 'd') ? 'selected' : '' }}>D</option>
                                    <option value="others" {{ (session('last_register') == 'others' || old('register') == 'others') ? 'selected' : '' }}>Others Year</option>
                                    <option value="revise" {{ (session('last_register') == 'revise' || old('register') == 'revise') ? 'selected' : '' }}>Revise</option>
                                </select>
                                @error('register')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="col-md-3">
                            <div class="form-group">                        
                                <label for="return_submission_date">Subimission Date*</label>                                
                                <input type="text" name="return_submission_date" id="return_submission_date" class="form-control" value="{{ session('subission_date'), date('d-m-Y') }}" placeholder="dd-mm-yyyy" required>
                                @error('return_submission_date')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="register_serial">Register Serial*</label>                                
                                <input type="number" name="register_serial" id="register_serial" placeholder="Register Serial" class="form-control" value="{{ session('next_register_serial', old('register_serial')) }}" required>
                                @error('register_serial')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>  

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tin" id="tinLabel">TIN*</label>
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
                                <label for="income_of_poultry_fisheries">Poultry/Fish Income</label>
                                <input type="number" name="income_of_poultry_fisheries" id="income_of_poultry_fisheries" placeholder="Poultry/Fish Income" class="form-control" value="{{ old('income_of_poultry_fisheries') }}">                            
                                @error('income_of_poultry_fisheries')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                       </div> 

                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="income_of_remittance">Remittance Income</label>
                                <input type="number" name="income_of_remittance" id="income_of_remittance" placeholder="Remittance Income" class="form-control" value="{{ old('income_of_remittance') }}">      

                                @error('income_of_remittance')
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
                                <input type="number" name="source_tax" id="source_tax" placeholder="Source Tax" class="form-control" value="{{ old('source_tax') }}" onkeyup="totalTax()">      

                                @error('source_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div>    

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="advance_tax">Advance Tax</label>
                                <input type="number" name="advance_tax" id="advance_tax" placeholder="Advance Tax" class="form-control" value="{{ old('advance_tax') }}" onkeyup="totalTax()">      

                                @error('advance_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="retarn_tax">Return Tax</label>
                                <input type="number" name="retarn_tax" id="retarn_tax" placeholder="Return Tax" class="form-control" value="{{ old('retarn_tax') }}" onkeyup="totalTax()">      

                                @error('retarn_tax')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="late_fee">Late Fee</label>
                                <input type="number" name="late_fee" id="late_fee" placeholder="Late Fee" class="form-control" value="{{ old('late_fee') }}" onkeyup="totalTax()">      

                                @error('late_fee')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sercharge">Surcharge</label>
                                <input type="number" name="sercharge" id="sercharge" placeholder="Surcharge" class="form-control" value="{{ old('sercharge') }}" onkeyup="totalTax()">      

                                @error('sercharge')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total_tax">Total Tax</label>
                                <input type="number" name="total_tax" id="total_tax" placeholder="Total Tax" class="form-control" value="{{ old('total_tax') }}" readonly>      

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
                                <input type="number" name="tax_of_schedule_one" id="tax_of_schedule_one" placeholder="Tax of Schedule One" class="form-control" value="{{ old('tax_of_schedule_one') }}" onkeyup="totalTax()">      

                                @error('tax_of_schedule_one')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="special_tax">Special Tax</label>
                                <input type="number" name="special_tax" id="special_tax" placeholder="Special Tax" class="form-control" value="{{ old('special_tax') }}" onkeyup="totalTax()">      

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

    //Total Tax
  function totalTax()
  {
        let source_tax = document.getElementById('source_tax').value;
        let advance_tax = document.getElementById('advance_tax').value;
        let retarn_tax = document.getElementById('retarn_tax').value;
        let late_fee = document.getElementById('late_fee').value;
        let sercharge = document.getElementById('sercharge').value;
        let tax_of_schedule_one = document.getElementById('tax_of_schedule_one').value;
        let special_tax = document.getElementById('special_tax').value;
      

      total_tax = Number(source_tax) + Number(advance_tax) + Number(retarn_tax) + Number(late_fee) + Number(sercharge) + Number(tax_of_schedule_one) + Number(special_tax);
      document.getElementById('total_tax').value = total_tax;
  }
    //Check the Stock
    function getStock() {
        let tin = document.getElementById('tin').value;
        let _token = "{{ csrf_token() }}";

        let data = {
            _token: _token,
            tin: tin
        };

        // Validate TIN length and format
        if (tin.length === 12 && !isNaN(tin)) {
            jQuery.ajax({
                url: "{{ route('circle.retarn.stock.check') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    let tinInput = document.getElementById('tin');
                    let tinLabel = document.getElementById('tinLabel');

                    // Reset styles
                    tinInput.style.background = "";
                    tinInput.style.color = "";
                    tinLabel.style.color = "";

                    // Update styles based on response
                    if (response.circleStatus === 'not added') {
                        tinInput.style.background = "red";
                    } else if (response.circleStatus === 'another') {
                        alert('TIN is out of circle.');
                        tinInput.style.background = "yellow";
                        tinInput.style.color = "black";
                        tinLabel.style.color = "red";
                        tinLabel.innerText = response.name + " (" + response.circle + ")";
                    } else if (response.circleStatus === 'same') {
                        tinInput.style.background = "green";
                        tinInput.style.color = "white";
                        tinLabel.style.color = "green";
                        tinLabel.innerText = response.name + " (" + response.circle + ")";
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        } 
    }


        //Get the last Register Serial Number and update
        function getRegisterSerial()
        {
            document.getElementById('register_serial').value = 'wait...';
            let assessment_year = document.getElementById('assessment_year').value;
            let register = document.getElementById('register').value;
            let _token   = "{{ csrf_token() }}";

            let data = {
                _token: _token,
                assessment_year: assessment_year,
                register: register
             }

            if( assessment_year == "" || register == "" )
            {
                alert('Select Ass. Year and Register First');
            }else
            {
                jQuery.ajax({
                url : "{{ route('circle.return.register.serial') }}",
                type: "POST",
                data: data,
                success: function(response)
                    {
                        if (response.next_register_serial) {
                            document.getElementById('register_serial').value = response.next_register_serial;
                        } else {
                            console.error('next_register_serial not found in response');
                        }
                        
                    },
                error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        }


    </script>
@endpush