<div class="form-group {{ $errors->has('address') ? ' has-error' : ''}} {{ $errors->has('address_2') ? ' has-error' : ''}}">
	<label for="address" class="col-sm-4 control-label">Address</label>
	<div class="col-sm-4">
	<input type="text" class="form-control" id="address" name="address" placeholder="400 N Wheeling Rd" value="{{ old('address') }}">
	</div>
	<div class="col-sm-2">
	<input type="text" class="form-control" id="address_2" name="address_2" placeholder="Unit 202" value="{{ old('address_2') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : ''}}">
	<label for="city" class="col-sm-4 control-label">City</label>
	<div class="col-sm-6">
	<input type="text" class="form-control" id="city" name="city" placeholder="Prospect Heights" value="{{ old('city') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : ''}} {{ $errors->has('zip_code') ? ' has-error' : ''}}">
	<label for="state" class="col-sm-4 control-label">State</label>
	<div class="col-sm-2">
	<input type="text" class="form-control" id="state" name="state" value="{{ old('state') == "" ? "IL" : old('state')}}">
	</div>
	<div class="col-sm-4">
	<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="60070" value="{{ old('zip_code') }}">
	</div>
</div>
		
<hr>