<div class="modal fade" id="it57" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">179 Notice <br> {{ $stock->bangla_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('circle.notice.57', $stock->tin) }}" method="POST" target="_blank" >
          @csrf

          <div class="form-group">
            <label for="assessment_year">Assessment Year (use -, here)</label>
            <input type="text" id="assessment_year" name="assessment_year" class="form-control" placeholder="2020-2021" required autofocus autocomplete="off">
          </div>

          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy"  required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="notice_section">Notice Section (use , here)</label>
            <input type="text" id="notice_section" name="notice_section" class="form-control" placeholder="179,183,212"  required autocomplete="off">
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