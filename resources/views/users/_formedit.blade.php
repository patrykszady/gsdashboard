<input name="user_id" id="user_id" type="hidden" value="{{ $user->id }}">
<div class="form-group {{ $errors->has('first_name') ? ' has-error' : ''}}">
	<label for="first_name" class="col-sm-4 control-label">First Name</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Patryk" value="{{ old('first_name') == "" ? $user->first_name : old('first_name') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('last_name') ? ' has-error' : ''}}">
	<label for="last_name" class="col-sm-4 control-label">Last Name</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Szady" value="{{ old('last_name') == "" ? $user->last_name : old('last_name') }}">
	</div>
</div>

<div class="form-group {{ $errors->has("email") ? ' has-error' : ''}}">
	<label for="email-{{$user->id}}" class="col-sm-4 control-label">Email</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="email-{{$user->id}}" name="email" placeholder="patryk.szady@live.com" value="{{ old("email") == "" ? $user->email : old("email") }}">
	</div>
</div>

<div class="form-group {{ $errors->has('phone_number') ? ' has-error' : ''}}">
	<label for="phone_number" class="col-sm-4 control-label">Cell Number</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="2249993880" value="{{ old('phone_number') == "" ? $user->getCellnumberraw() : old('phone_number') }}">
	</div>
</div>
<hr>


