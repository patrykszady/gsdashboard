<div class="form-group {{ $errors->has('business_name') ? ' has-error' : ''}}">
	<label for="business_name" class="col-sm-4 control-label">Business Name</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="business_name" name="business_name" placeholder="PLR Properties, LLC" value="{{ old('business_name') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

@include('partials._addressform')

<div class="form-group {{ $errors->has('home_phone') ? ' has-error' : ''}}">
	<label for="home_phone" class="col-sm-4 control-label">Home Phone</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="home_phone" name="home_phone" placeholder="2249993880" value="{{ old('home_phone') }}">
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
	</div>
</div>
<hr>