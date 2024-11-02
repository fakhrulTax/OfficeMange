       <!-- Modal -->
       <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">

       <form action="{{ route('circle.return.excel') }}" method="POST" target="_balnk">
        @csrf
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Excel Download</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="register" id="register" class="form-control">
                                <option value="">Register</option>
                                <option value="a" >A</option>                               
                                <option value="b" >B</option>                               
                                <option value="c" >C</option>                               
                                <option value="d" >D</option>                               
                                <option value="others" >Othres Year</option>                               
                                <option value="revise" >Revise</option>                               
                            </select>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="assessment_year" placeholder="20242025">
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

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Download</button>
            </div>                

            </div>
        </form>

        </div>
    </div>