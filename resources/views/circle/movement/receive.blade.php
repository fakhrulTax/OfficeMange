<div class="card card-danger">
  <div class="card-header">
    <h2 class="card-title">Receive Movement</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('circle.movement.receive.update', $receiveMovement->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">

        <div class="col-md-3">
            <div class="form-group">             
              <input type="text" name="receive_date" id="receive_date" class="form-control" value="{{ old('receive_date') }}" placeholder="dd-mm-yyyy" required>
              @error('receive_date')
                  <div class="text text-danger">{{ $message }}</div>
              @enderror
          </div>
        </div>    

        <div class="col-md-1">
          <button type="submit" class="btn btn-primary">Receive</button>
        </div>
        
      </div>

    </form>
  </div>
</div>