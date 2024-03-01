<div class="modal fade" id="order" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Sheet: {{ $stock->bangla_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <form action="{{ route('circle.notice.order.sheet', $stock->tin) }}" method="POST" target="_blank" >
          @csrf

          <div class="form-group">
            <label for="assessment_year">Type</label>

            <select name="type" id="type" class="form-control" required>
              <option value="212">212</option>
              <option value="280">280</option>
              <option value="212280">212 & 280</option>
              <option value="179">179</option>
              <option value="179183">179 & 183</option>
            </select>
        </div>

        <div class="form-group">
            <label for="assessment_year">Assessment Year</label>
            @error('assessment_year')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="number" id="assessment_year" name="assessment_year" class="form-control" placeholder="20202021" required>
        </div>

          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            @error('issue_date')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="hearing_date">Hearing Date</label>
            @error('hearing_date')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="text" id="hearing_date" name="hearing_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" required>
          </div> 

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Print</button>
        </div>
      </form>
    </div>
  </div>
</div>