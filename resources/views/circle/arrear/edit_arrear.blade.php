

    <div class="col-12">
        <h4 class="text-danger error">

        </h4>
    </div>

    <form action="" method="POST" id="edit-arrear-form">
        @csrf

        
        <div class="row">
            <input type="hidden" name="id" id="id" value="{{ $arrear->id }}" >

            <div class="col-md-6">
                <div class="form-group">
                    <label for="arrear_type"> Arrear Type</label>
                    <select name="arrear_type" id="arrear_type" class="form-control">
                        <option value="disputed" {{ $arrear->arrear_type == 'disputed' ? 'selected' : ''}} >Disputed</option>
                        <option value="undisputed" {{ $arrear->arrear_type == 'undisputed' ? 'selected' : ''}}>UnDisputed</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="tin">TIN Number</label>
                    <input type="number" class="form-control"
                         value="{{ $arrear->tin }}" readonly >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="demand_create_date"> Demand Create Date </label>
                    <input type="date" class="form-control" id="demand_create_date"
                        name="demand_create_date" value="{{ date('Y-m-d', strtotime($arrear->demand_create_date)) }}">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="assessment_year">Assesment Year</label>
                    <input type="number" class="form-control" id="assessment_year"
                        name="assessment_year" value="{{ $arrear->assessment_year }}">
                </div>
            </div>




            <div class="col-md-6">
                <div class="form-group">
                    <label for="arrear"> Arrear</label>
                    <input type="number" class="form-control" id="arrear" name="arrear"
                        value="{{ $arrear->arrear }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fine">Fine</label>
                    <input type="number" class="form-control" id="fine" name="fine"
                        value="{{ $arrear->fine }}">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="comments"> Comments </label>
                    <textarea name="comments" id="comments" cols="30" rows="2" class="form-control">{{ $arrear->comments }} </textarea>
                </div>
            </div>

        </div>
    </form>


