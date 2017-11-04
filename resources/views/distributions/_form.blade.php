<div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
	<label for="name" class="col-sm-4 control-label">Account Name</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="name" name="name" placeholder="Owner - Home" value="{{ old('name', isset($distribution) ? $distribution->name->format('m/d/y') : '') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('user_id') ? ' has-error' : ''}}">
	<label for="user_id" class="col-sm-4 control-label">Employee</label>
	<div class="col-sm-6">
		<select class="form-control" id="user_id" name="user_id">
			{{-- Can we put old('user_id') elsewhere? to clean up this view? --}}
			<option value="0" 
				{{ old('user_id', isset($distribution) ? $distribution->user_id : '') == "0" ? "selected" : "" }}>
				Not Associated
			</option>
			@foreach ($employees as $employee)
			<option value="{{$employee->id}}" 
				{{ old('user_id', isset($distribution) ? $distribution->user_id : '') == $employee->id ? "selected" : "" }}>
				{{ $employee->first_name }}
			</option>
			@endforeach
		</select>
	</div>
</div>