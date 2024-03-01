<div class="modal fade" id="demand" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Demand Notice: {{ $stock->bangla_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('circle.notice.demand', $stock->tin) }}" method="POST" target="_blank" >
          @csrf

          <div class="form-group">
            <label for="class">Section</label>
           <input type="text" id="section" name="section" class="form-control" placeholder="212/183(3)" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="class">Status</label>
            <select name="class" id="class" class="form-control" required>
              <option value="ব্যাক্তি">ব্যক্তি</option>
              <option value="ফার্ম">ফার্ম</option>
              <option value="কোম্পানী">কোম্পানী</option>
            </select>
          </div>

          <div class="form-group">
            <label for="assessment_year">Assessment Year</label>
            <input type="number" id="assessment_year" name="assessment_year" class="form-control" placeholder="20202021" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="issue_date">Issue Date</label>
            <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="hearing_date">Hearing Date</label>
            <input type="text" id="hearing_date" name="hearing_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" required>
          </div>  

          <div class="form-group">
            <label for="tax">Tax</label>
            <input type="number" id="tax" name="tax" class="form-control" placeholder="Tax" autocomplete="off" required>
          </div>    

          <div class="form-group">
            <label for="fine">Fine</label>
            <input type="number" id="fine" name="fine" class="form-control" placeholder="Fine"  autocomplete="off" required>
          </div>           

          <div class="form-group">
            <label for="interest">Interest</label>
            <input type="number" id="interest" name="interest" class="form-control" placeholder="Interest"  autocomplete="off" required>
          </div>            

          <div class="form-group">
            <label for="surcharge">Surcharge</label>
            <input type="number" id="surcharge" name="surcharge" class="form-control" placeholder="Surcharge" autocomplete="off" required>
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