<div class="form-group  {{$errors->has('hourly') ? ' has-error' : ''}}">
	<label for="hourly" class="col-sm-4 control-label">Vendor</label>
	<div class="col-sm-6">
		<input type="text" disabled class="form-control" id="output" name="hourly" 
			value="{{$vendor->business_name}}">
	</div>
	<input name="vendor_id" type="hidden" value="{{ $vendor->id }}">
</div>

<hr>

@foreach ($projects as $key => $project)
<div class="form-group  {{$errors->has("amount.$key") ? ' has-error' : ''}}">
	<label for="amount[]" class="col-sm-4 control-label">{{ $project->getProjectname() }}</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="amount.$key" placeholder="1200" name="amount[]" value="{{ old("amount.$key") }}">
	</div>
	<input name="project_id[]" type="hidden" value="{{ $project->id }}">
</div>
@endforeach

<hr>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
	</div>
</div>

{{-- <div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Add Payment</button>
	</div>
</div> --}}