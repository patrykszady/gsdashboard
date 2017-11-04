<div class="form-group {{ $errors->has('business_name') ? ' has-error' : ''}}">
	<label for="business_name" class="col-sm-4 control-label">Business Name</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="business_name" name="business_name" placeholder="PLR Properties, LLC" value="{{ old('business_name') == "" ? $client->business_name : old('business_name') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('address') ? ' has-error' : ''}}">
	<label for="address" class="col-sm-4 control-label">Address</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="address" name="address" placeholder="400 N Wheeling Rd" value="{{ old('address') == "" ? $client->address : old('address') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('address_2') ? ' has-error' : ''}}">
	<label for="address_2" class="col-sm-4 control-label">Unit</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="address_2" name="address_2" placeholder="Unit 202" value="{{ old('address_2') == "" ? $client->address_2 : old('address_2') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : ''}}">
	<label for="city" class="col-sm-4 control-label">City</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="city" name="city" placeholder="Prospect Heights" value="{{ old('city') == "" ? $client->city : old('city') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : ''}}">
	<label for="state" class="col-sm-4 control-label">State</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="state" name="state" value="{{ old('state') == "" ? $client->state : old('state') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('zip_code') ? ' has-error' : ''}}">
	<label for="zip_code" class="col-sm-4 control-label">Zip Code</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="60070" value="{{ old('zip_code') == "" ? $client->zip_code : old('zip_code') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('home_phone') ? ' has-error' : ''}}">
	<label for="home_phone" class="col-sm-4 control-label">Home Phone</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="home_phone" name="home_phone" placeholder="2249993880" value="{{ old('home_phone') == "" ? $client->getHomephonerraw() : old('home_phone') }}">
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') == "" ? $client->note : old('note') }}</textarea>
	</div>
</div>
<hr>