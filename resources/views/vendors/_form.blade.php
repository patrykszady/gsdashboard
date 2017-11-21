<div class="form-group {{ $errors->has('business_name') ? ' has-error' : ''}}">
	<label for="business_name" class="col-sm-4 control-label">Business Name</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="business_name" name="business_name" placeholder="GS Construction" value="{{ old('business_name', isset($vendor) ? $vendor->business_name : '') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('address') ? ' has-error' : ''}} {{ $errors->has('address_2') ? ' has-error' : ''}}">
	<label for="address" class="col-sm-4 control-label">Address</label>
	<div class="col-sm-4">
	<input type="text" class="form-control" id="address" name="address" placeholder="400 N Wheeling Rd" value="{{ old('address', isset($vendor) ? $vendor->address : '') }}">
	</div>
	<div class="col-sm-2">
	<input type="text" class="form-control" id="address_2" name="address_2" placeholder="Unit 202" value="{{ old('address_2', isset($vendor) ? $vendor->address_2 : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : ''}}">
	<label for="city" class="col-sm-4 control-label">City</label>
	<div class="col-sm-6">
	<input type="text" class="form-control" id="city" name="city" placeholder="Prospect Heights" value="{{ old('city', isset($vendor) ? $vendor->city : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : ''}} {{ $errors->has('zip_code') ? ' has-error' : ''}}">
	<label for="state" class="col-sm-4 control-label">State</label>
	<div class="col-sm-2">
	<input type="text" class="form-control" id="state" name="state" value="{{ old('state', isset($vendor) ? $vendor->state : 'IL') }}">
	</div>
	<div class="col-sm-4">
	<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="60070" value="{{ old('zip_code', isset($vendor) ? $vendor->zip_code : '') }}">
	</div>
</div>
		
<hr>

<div class="form-group {{ $errors->has('biz_phone') ? ' has-error' : ''}}">
	<label for="biz_phone" class="col-sm-4 control-label">Business Phone</label>
	<div class="col-sm-6">
	<input type="text" class="form-control" id="biz_phone" name="biz_phone" placeholder="2249993880" value="{{ old('biz_phone', isset($vendor) ? $vendor->biz_phone : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="biz_type" class="col-sm-4 control-label">Type</label>
	<div class="col-sm-6">
		<select class="form-control" id="biz_type" name="biz_type">
			<option value="1" {{ old('biz_type', isset($vendor) ? $vendor->biz_type : '') == 1 ? "selected" : "" }}>Sub Contractor</option>
			<option value="2" {{ old('biz_type', isset($vendor) ? $vendor->biz_type : '') == 2 ? "selected" : "" }}>Vendor</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note', isset($vendor) ? $vendor->note : '') }}</textarea>
	</div>
</div>