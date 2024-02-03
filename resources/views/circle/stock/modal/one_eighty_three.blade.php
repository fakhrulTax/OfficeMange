<div class="modal fade" id="oneEightyThree" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">183(3) Notice <br> {{ $stock->bangla_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/notice/{{$stock->tin}}/183" method="POST" target="_blank" >
          @csrf
          <div class="form-group">
            <label for="assessment_year">Assessment Year</label>
            @error('assessment_year')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="integer" id="assessment_year" name="assessment_year" class="form-control" placeholder="20202021" autofocus>
          </div>
          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            @error('issue_date')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy">
          </div>
          <div class="form-group">
            <label for="hearing_date">Hearing Date</label>
            @error('hearing_date')
              <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="text" id="hearing_date" name="hearing_date" class="form-control" placeholder="dd-mm-yyyy">
          </div>       
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="submit" class="btn btn-primary">Print</button> --}}

        <input type="submit" value="Print" class="btn btn-primary" >


        </div>
      </form>
    </div>
  </div>
</div>