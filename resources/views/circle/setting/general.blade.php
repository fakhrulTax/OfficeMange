<div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
  <div class="form-group">
    <label for="circle_name_{{ Auth::user()->circle }}">Circle Name</label>
    <input type="text" name="circle_name_{{ Auth::user()->circle }}" id="circle_name_{{ Auth::user()->circle }}" placeholder="সার্কেল-১৪, নোয়াখালী" class="form-control" value="{{ config('settings.circle_name_'.Auth::user()->circle) }}">
  </div>
  <div class="form-group">
    <label for="assessment_year_{{ Auth::user()->circle }}">Assessment Year</label>
    <input type="text" name="assessment_year_{{ Auth::user()->circle }}" id="assessment_year_{{ Auth::user()->circle }}" class="form-control" placeholder="20232024" value="{{ config('settings.assessment_year_'.Auth::user()->circle) }}">
  </div>
  <div class="form-group">
    <label for="officer_designation_{{ Auth::user()->circle }}">Officer Designation(Short Form)</label>
    <input type="text" name="officer_designation_{{ Auth::user()->circle }}" id="officer_designation_{{ Auth::user()->circle }}" class="form-control" placeholder="উঃ কঃ কঃ" value="{{ config('settings.officer_designation_'.Auth::user()->circle) }}">
  </div>
  <div class="form-group">
    <label for="circle_address_{{ Auth::user()->circle }}">Circle Address</label>
    <textarea name="circle_address_{{ Auth::user()->circle }}" id="circle_address_{{ Auth::user()->circle }}" class="summernote form-control" cols="30" rows="5">{{ config('settings.circle_address_'.Auth::user()->circle) }}</textarea>
  </div>
  <div class="form-group">
    <label for="notice_address_{{ Auth::user()->circle }}">Notice Address(Like Notice Top)</label>
    <textarea name="notice_address_{{ Auth::user()->circle }}" id="notice_address_{{ Auth::user()->circle }}" class="summernote form-control" cols="30" rows="5">{{ config('settings.notice_address_'.Auth::user()->circle) }}</textarea>
  </div>
  <div class="form-group">
    <label for="officer_name_{{ Auth::user()->circle }}">Circle Officer with full address(Like Notice Bottom)</label>
    <textarea name="officer_name_{{ Auth::user()->circle }}" id="officer_name_{{ Auth::user()->circle }}" class="summernote form-control" cols="30" rows="5">{{ config('settings.officer_name_'.Auth::user()->circle) }}</textarea>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="sidebar_collapse_{{ Auth::user()->circle }}" value="1" id="sidebar_collapse_{{ Auth::user()->circle }}" {{ (config('settings.sidebar_collapse_'.Auth::user()->circle))?'checked':'' }}>
    <label class="form-check-label" for="sidebar_collapse_{{ Auth::user()->circle }}">
      Sidebar Collapse
    </label>
  </div>
</div>