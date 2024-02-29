<div class="modal fade" id="oneSeventyNine" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">179 Notice <br> {{ $stock->bangla_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('circle.notice.179', $stock->tin) }}" method="POST" target="_blank" >
          @csrf

          <div class="form-group">
            <label for="assessment_year">Assessment Year</label>
            <input type="number" id="assessment_year" name="assessment_year" class="form-control" placeholder="20202021" required autofocus autocomplete="off">
          </div>

          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy"  required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="hearing_date">Hearing Date</label>
            <input type="text" id="hearing_date" name="hearing_date" class="form-control" placeholder="dd-mm-yyyy"  required autocomplete="off">
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