@if(isset($user))
	<div class="row">
		<div class="col-sm-4">
		<h4>Name</h4>
		</div>
		<div class="col-sm-6">
			<h3>{{$user->getFullname() }}</h3>
		</div>
	</div>
	<input name="user_id" id="user_id" type="hidden" value="{{ $user->id }}">
@endif

@if(isset($client))
	<div class="form-group">
		<label for="client_id" class="col-sm-4 control-label">Selected Client</label>
		<div class="col-sm-6">
			<input type="hidden" id="client_id" name="client_id" value="{{ $client->id }}">

			<input type="text" class="form-control" id="client_id" name="client_id" disabled value="{{ $client->getName()}}">
		</div>
	</div>
@endif

@if(isset($vendor))
	<div class="form-group">
		<label for="vendor_id" class="col-sm-4 control-label">Selected Vendor</label>
		<div class="col-sm-6">
			<input type="hidden" id="vendor_id" name="vendor_id" value="{{ $vendor->id }}">

			<input type="text" class="form-control" id="vendor_id" name="vendor_id" disabled value="{{ $vendor->business_name}}">
		</div>
	</div>
@endif

@if(isset($users))
<div class="form-group {{ $errors->has('user_id') ? ' has-error' : ''}}">
	<label for="user_id" class="col-sm-4 control-label">Existing Contact</label>
	<div class="col-sm-6">
		<select class="form-control" id="user_id" name="user_id">
			<option value="" 
					{{ old('user_id') == null ? "selected" : "" }}>Add New Contact</option>
			@foreach ($users as $user)
				<option value="{{$user->id}}" 
					{{ old('user_id') == $user->id ? "selected" : "" }}>{{ $user->getFullname() }}
				</option>
			@endforeach
		</select>
	</div>
</div>
<hr>
@endif
<div id="row_dim">
	<div class="form-group {{ $errors->has('first_name') ? ' has-error' : ''}}">
		<label for="first_name" class="col-sm-4 control-label">First Name</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Patryk" value="{{ old('first_name') }}">
		</div>
	</div>

	<div class="form-group {{ $errors->has('last_name') ? ' has-error' : ''}}">
		<label for="last_name" class="col-sm-4 control-label">Last Name</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Szady" value="{{ old('last_name') }}">
		</div>
	</div>

	<div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
		<label for="email" class="col-sm-4 control-label">Email</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="email" name="email" placeholder="patryk.szady@live.com" value="{{ old('email') }}">
		</div>
	</div>

	<div class="form-group {{ $errors->has('phone_number') ? ' has-error' : ''}}">
		<label for="phone_number" class="col-sm-4 control-label">Cell Phone</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="2249993880" value="{{ old('phone_number') }}">
		</div>
	</div>
	<hr>
</div>
