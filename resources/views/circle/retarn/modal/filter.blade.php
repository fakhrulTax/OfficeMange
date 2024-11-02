       <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">

       <form action="{{ route('circle.return.filter') }}" method="GET">
        @csrf
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Filter Return</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Enter TIN to filter" value="{{ request()->get('tin') }}">
                            @error('tin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="assessment_year" name="assessment_year" placeholder="20242025" value="{{ request()->get('assessment_year') }}">
                            @error('assessment_year')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="source_of_income" name="source_of_income" placeholder="Source Of Income" value="{{ request()->get('source_of_income') }}">
                            @error('source_of_income')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="income_of_poultry_fisheries" id="income_of_poultry_fisheries" class="form-control">
                                <option value="">Shown Poultry Fisheries?</option>
                                <option value="1" {{ request()->get('income_of_poultry_fisheries') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ request()->get('income_of_poultry_fisheries') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('income_of_poultry_fisheries')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="income_of_remittance" id="income_of_remittance" class="form-control">
                                <option value="">Shown Remittance</option>
                                <option value="1" {{ request()->get('income_of_remittance') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ request()->get('income_of_remittance') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('income_of_remittance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="sercharge" id="sercharge" class="form-control">
                                <option value="">Sercharge?</option>
                                <option value="1" {{ request()->get('sercharge') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ request()->get('sercharge') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('sercharge')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="submission_date_from" autocomplete="off" placeholder="Submission Date From" name="submission_date_from" value="{{ request()->get('submission_date_from') }}">
                            @error('submission_date_from')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="submission_date_to" autocomplete="off" name="submission_date_to" placeholder="Submission Date To" value="{{ request()->get('submission_date_to') }}">
                            @error('submission_date_to')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="order_by" id="order_by" class="form-control">
                                <option value="">Order By</option>
                                <option value="register_serial" {{ request()->get('order_by') == 'register_serial' ? 'selected' : '' }}>Register Serial</option>
                                <option value="return_submission_date" {{ request()->get('order_by') == 'return_submission_date' ? 'selected' : '' }}>Submission Date</option>
                                <option value="income" {{ request()->get('order_by') == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="total_tax" {{ request()->get('order_by') == 'total_tax' ? 'selected' : '' }}>Tax</option>
                                <option value="net_asset" {{ request()->get('order_by') == 'net_asset' ? 'selected' : '' }}>Net Asset</option>
                            </select>
                            @error('order_by')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="asc_desc" id="asc_desc" class="form-control">
                                <option value="asc" {{ request()->get('asc_desc') == 'asc' ? 'selected' : '' }}>ASC</option>
                                <option value="desc" {{ request()->get('asc_desc') == 'desc' ? 'selected' : '' }}>DESC</option>
                            </select>
                            @error('asc_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>                

            </div>
        </form>

        </div>
    </div>