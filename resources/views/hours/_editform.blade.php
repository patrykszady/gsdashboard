<div class="form-group  {{$errors->has('user_id') ? ' has-error' : ''}}">
	<label for="user_id" class="col-sm-4 control-label">Employee</label>
	<div class="col-sm-6">
		<select class="form-control" id="user_id" name="user_id">
			{{-- Can we put old('user_id') elsewhere? to clean up this view? --}}
			@foreach ($employees as $employee)
			<option rel="{{$employee->hours()->orderBy('created_at', 'desc')->value('hourly')}}" value="{{$employee->id}}" 
				{{ old('user_id', $hour->user_id) == $employee->id ? "selected" : "" }}>
				{{ $employee->first_name }}
			</option>
			@endforeach
		</select>
	</div>
</div>

<hr>

<div class="form-group  {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	<div class="col-sm-6">
		<select class="form-control" id="date" name="date">
			@foreach ($mondays as $monday)
				<option value="{{$monday}}" {{ $hour->date == $monday->toDateTimeString() ? "selected" : "" }}>{{$monday->toFormattedDateString()}}
				</option>
			@endforeach	
		</select>
	</div>
</div>

<hr>

<div class="form-group  {{$errors->has('hourly') ? ' has-error' : ''}}">
	<label for="hourly" class="col-sm-4 control-label">Hourly Pay</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="output" name="hourly" 
			value="{{ old('hourly', $hour->hourly) }}">
	</div>
</div>

<hr>



@foreach ($projects as $key => $project)
<div class="form-group  {{$errors->has("hours.$key") ? ' has-error' : ''}}">
	<label for="hours[]" class="col-sm-4 control-label">{{ $project->getProjectname() }}</label>

	<div class="col-sm-6">
		<input type="text" class="form-control" id="hours.$key" placeholder="20 Hours" name="hours[]" value="{{ old("hours.$key", isset($hours->where('project_id', $project->id)->first()->hours)) ? $hours->where('project_id', $project->id)->first()->hours : "" }}">
	</div>
	<input name="project_id[]" type="hidden" value="{{ $project->id }}">
</div>
@endforeach

<hr>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note', $hour->note) }}</textarea>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Update Timesheet</button>
	</div>
</div>