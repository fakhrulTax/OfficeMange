<div class="tab-pane text-left fade show active" id="vert-tabs-tds" role="tabpanel" aria-labelledby="vert-tabs-tds-tab">
  
  <div class="form-group">
    <label for="assessment_year_{{ Auth::user()->circle }}">Select Circle Distict</label>
    <select class="form-control" id="zilla" name="distict_{{ Auth::user()->circle }}" required>
        <option value="">Select Distict</option>
        @foreach ($zillas as $zilla)
            <option value="{{ $zilla->id }}" {{ (config('settings.distict_' . Auth::user()->circle  ) == $zilla->id) ? 'selected' : ''}} >{{ ucfirst($zilla->name) }}</option>
        @endforeach
    </select>
  </div>

    <div class="form-group">
        <label for="upazila">Circle TDS Juridiction Upazillas</label>
        <select class="form-control" name="upazila_id_{{ Auth::user()->circle }}[]" id="upazila" multiple="multiple">
            <option value="">Select Upazilla</option>
            @foreach($selectedUpazilas as $upazila)
             <option value="{{ $upazila->id }}" selected>{{ ucfirst($upazila->name) }}</option>
            @endforeach
        </select>
    </div>

</div>