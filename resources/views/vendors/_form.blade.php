<div class="form-group {{ $errors->has('business_name') ? ' has-error' : ''}}">
	<label for="business_name" class="col-sm-4 control-label">Business Name</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="business_name" name="business_name" placeholder="GS Construction" value="{{ old('business_name') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

@include('partials._addressform')

<div class="form-group {{ $errors->has('biz_phone') ? ' has-error' : ''}}">
	<label for="biz_phone" class="col-sm-4 control-label">Business Phone</label>
	<div class="col-sm-6">
	<input type="text" class="form-control" id="biz_phone" name="biz_phone" placeholder="2249993880" value="{{ old('biz_phone') }}">
	</div>
</div>

<div class="form-group">
	<label for="biz_type" class="col-sm-4 control-label">Type</label>
	<div class="col-sm-6">
		<select class="form-control" id="biz_type" name="biz_type">
			<option value="1" {{ old('biz_type') == 1 ? "selected" : "" }} {{ old('biz_type') == null ? "selected" : "" }} >Sub Contractor</option>
			<option value="2" {{ old('biz_type') == 2 ? "selected" : "" }}>Vendor</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Save</button>
	</div>
</div>