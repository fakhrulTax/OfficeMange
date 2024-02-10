<div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
  
  <div class="form-group">
    <label for="assessment_year_commissioner">Assessment Year</label>
    <input type="text" name="assessment_year_commissioner" id="assessment_year_commissioner" class="form-control" placeholder="20232024" value="{{ config('settings.assessment_year_commissioner') }}">
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="sidebar_collapse_commissioner" value="1" id="sidebar_collapse_commissioner" {{ (config('settings.sidebar_collapse_commissioner'))?'checked':'' }}>
    <label class="form-check-label" for="sidebar_collapse_commissioner">
      Sidebar Collapse
    </label>
  </div>
</div>