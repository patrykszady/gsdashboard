<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="date" name="date" placeholder="{{ date('m/d/y') }}" value="{{ old('date', isset($check) ? $check->date->format('m/d/y') : '') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="check" class="col-sm-4 control-label">Check #</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="check" name="check" placeholder="1234.56" value="{{ old('check', isset($check) ? $check->check : '') }}">
	</div>
</div>

@if(isset($check))

<input type="hidden" name="check_id" value="{{$check->id}}">

@endif
