<div class="card card-danger">
  <div class="card-header">
    <h2 class="card-title">Move File</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('circle.movement.store') }}" method="POST">
    @csrf
      <div class="row">

        <div class="col-md-2">
          <div class="form-group">             
            <input type="number" name="tin" class="form-control" id="tin" placeholder="TIN" value="{{ old('tin') }}" required>
            @error('tin')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">             
              <input type="text" name="move_date" id="move_date" value="{{ old( 'move_date') }}" class="form-control" placeholder="dd-mm-yyyy" required>
              @error('move_date')
                  <div class="text text-danger">{{ $message }}</div>
              @enderror
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">             
            <select name="office_name" id="office_name" class="form-control" required>
              <option value="">Select Office</option>
              <option value="range" {{ (old('office_name') == 'range') ? 'selected' : ''  }}>Range</option>
              <option value="commissioner" {{ (old('office_name') == 'commissioner') ? 'selected' : ''  }}>Commissioner</option>
              <option value="appeal" {{ (old('office_name') == 'appeal') ? 'selected' : ''  }}>Appeal</option>
              <option value="tribunal" {{ (old('office_name') == 'tribunal') ? 'selected' : ''  }}>Tribunal</option>
              <option value="high_court" {{ (old('office_name') == 'high_court') ? 'selected' : ''  }}>High Court</option>
              <option value="review" {{ (old('office_name') == 'review') ? 'selected' : ''  }}>review</option>
              <option value="others" {{ (old('office_name') == 'others') ? 'selected' : ''  }}>others</option>
            </select>
            @error('office_name')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="col-md-5">
          <div class="form-group">
          <select id="assessment_year" name="assessment_year[]" multiple="multiple" class="form-control" value="{{ old( 'move_date') }}" required>
                @for ($i = 20232024; $i >= 20052006; $i -= 10001)
                    <option value="{{ $i }}" {{ (in_array($i, old('assessment_year') ?? [])) ? 'selected' : '' }}>{{ App\Helpers\MyHelper::assessment_year_format($i) }}</option>
                @endfor
            </select>
            @error('assessment_year')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="col-md-1">
          <button type="submit" class="btn btn-primary">Move</button>
        </div>
      </div>

    </form>
  </div>
</div>