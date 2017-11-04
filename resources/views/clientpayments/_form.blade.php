<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="date" name="date" value="{{ old('date', date('m/d/y')) }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('amount') ? ' has-error' : ''}}">
	<label for="amount" class="col-sm-4 control-label">Amount</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" class="form-control" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount') }}">
		</div>
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

<div class="form-group {{ $errors->has('check_id') ? ' has-error' : ''}}">
	<label for="check_id" class="col-sm-4 control-label">Check</label>
	<div class="col-sm-6">
		<input type="number" class="form-control" id="check_id" placeholder="1020" name="check_id" value="{{ old('check_id') }}">
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
	</div>
</div>

