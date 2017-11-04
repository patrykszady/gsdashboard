<div class="form-group {{ $errors->has('amount') ? ' has-error' : ''}}">
	<label for="amount" class="col-sm-4 control-label">Amount $</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount') }}">
	</div>
</div>
<div class="form-group">
	<label for="project_id" class="col-sm-4 control-label">Project</label>
	<div class="col-sm-6">
		<select class="form-control" id="project_id" name="project_id">
			@foreach ($projects as $project)
			<option value="{{$project->id}}" 
				{{ old('project_id') == $project->id ? "selected" : "" }}>
				{{ $project->getProjectname() }}
				</option>
			@endforeach
		</select>
	</div>
</div>
<div class="form-group">
	<label for="vendor_id" class="col-sm-4 control-label">Vendor</label>
	<div class="col-sm-6">
		<select class="form-control" id="vendor_id" name="vendor_id">
			@foreach ($vendors as $vendor)
			<option value="{{$vendor->id}}" 
				{{ old('vendor_id') == $vendor->id ? "selected" : "" }}>
				{{ $vendor->business_name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

{{-- <div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
	</div>
</div> --}}

