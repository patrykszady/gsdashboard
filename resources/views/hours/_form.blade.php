<div class="form-group  {{$errors->has('employee') ? ' has-error' : ''}}">
	<label for="user_id" class="col-sm-4 control-label">Employee</label>
	<div class="col-sm-6">
		<select class="form-control" id="user_id" name="user_id">
			{{-- Can we put old('user_id') elsewhere? to clean up this view? --}}
			@foreach ($employees as $employee)
			<option rel="{{$employee->hours()->orderBy('created_at', 'desc')->value('hourly')}}" value="{{$employee->id}}" 
				{{ old('user_id') == $employee->id ? "selected" : "" }}>
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
				<option value="{{$monday}}" {{ old('date') == $monday ? "selected" : "" }}>{{$monday->toFormattedDateString()}}</option>
			@endforeach	
		</select>
	</div>
</div>

<hr>

<div class="form-group  {{$errors->has('hourly') ? ' has-error' : ''}}">
	<label for="hourly" class="col-sm-4 control-label">Hourly Pay</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="output" name="hourly" 
			value="">
	</div>
</div>

<hr>

@foreach ($projects as $key => $project)
<div class="form-group {{$errors->has("hours.$key") ? ' has-error' : ''}}">
	<label for="hours" class="col-sm-4 control-label">{{ $project->getProjectname() }}</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="hours{{$key}}" name="hours[]" placeholder="20 Hours" value="{{ old("hours.$key") }}">
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

<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Add Payment</button>
	</div>
</div>