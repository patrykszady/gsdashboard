<div class="form-group {{ $errors->has('project_name') ? ' has-error' : ''}}">
	<label for="project_name" class="col-sm-4 control-label">Project Name</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Master Bath" value="{{ old('project_name', isset($project) ? $project->project_name : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('client_id') ? ' has-error' : ''}}">
	<label for="client_id" class="col-sm-4 control-label">Client</label>
	<div class="col-sm-6">
		<div class="input-group">
			<select class="form-control" id="client_id" name="client_id">
				@foreach ($clients as $client)
					<option value="{{$client->id}}" 
						{{ old('client_id', isset($project) ? $project->client_id : '') == $client->id ? "selected" : "" }}>
						{{ $client->getName() }}
					</option>
				@endforeach
			</select>
			<span class="input-group-btn">
				<a href="{{ route('clients.create') }}" class="btn btn-primary">New</a>
			</span>
		</div>
	</div>
</div>


<hr>
@if(!isset($project))
<div class="form-group">
	<label class="col-xs-4 control-label">Jobsite Address</label>
	<div class="col-xs-8">
		<div class="radio">
			<label>
				<input id="inlineradio1" name="jobsite_address" value="1" type="radio" {{ old('jobsite_address') == 1 ? "checked" : "checked" }}>
					@foreach ($clients as $client)
							<div class="{{$client->id}} box">
								{!! $client->getFulladdress() !!}
							</div>
					@endforeach
			</label>
		</div>
		<div class="radio">
			<label>
				<input id="inlineradio2" name="jobsite_address" value="2" type="radio" {{ old('jobsite_address') == 2 ? "checked" : "" }}>
			New Address
			</label>
		</div>
	</div>
</div>
@elseif($clients->count() > 1)
@endif

{{-- 	<div class="form-group">
		<label for="client_id" class="col-sm-4 control-label">Selected Client</label>
		<div class="col-sm-6">
			<input type="hidden" id="client_id" name="client_id" value="{{ $client->id }}">

			<input type="text" class="form-control" id="client_id" name="client_id" disabled value="{{ $client->getName()}}">
		</div>
	</div> --}}

<div id="row_dim"> {{-- Row for jquery to hide/show section --}}
<div class="form-group {{ $errors->has('address') ? ' has-error' : ''}} {{ $errors->has('address_2') ? ' has-error' : ''}}">
	<label for="address" class="col-sm-4 control-label">Address</label>
	<div class="col-sm-4">
		<input type="text" class="form-control" id="address" name="address" placeholder="400 N Wheeling Rd" value="{{ old('address', isset($project) ? $project->address : '') }}">
	</div>
	<div class="col-sm-2">
		<input type="text" class="form-control" id="address_2" name="address_2" placeholder="Unit 202" value="{{ old('address_2', isset($project) ? $project->address_2 : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : ''}}">
	<label for="city" class="col-sm-4 control-label">City</label>
	<div class="col-sm-6">
	<input type="text" class="form-control" id="city" name="city" placeholder="Prospect Heights" value="{{ old('city', isset($project) ? $project->city : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : ''}} {{ $errors->has('zip_code') ? ' has-error' : ''}}">
	<label for="state" class="col-sm-4 control-label">State</label>
	<div class="col-sm-2">
	<input type="text" class="form-control" id="state" name="state" value="{{ old('state', isset($project) ? $project->state : '') }}">
	</div>
	<div class="col-sm-4">
	<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="60070" value="{{ old('zip_code', isset($project) ? $project->zip_code : '') }}">
	</div>
</div>
</div>
<hr>

<div class="form-group {{ $errors->has('project_total') ? ' has-error' : ''}}">
	<label for="project_total" class="col-sm-4 control-label">Project Total</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" class="form-control" id="project_total" name="project_total" placeholder="1234.56" value="{{ old('project_total', isset($project) ? $project->project_total : '') }}">
		</div>
	</div>
</div>
<div class="form-group {{ $errors->has('change_order') ? ' has-error' : ''}}">
	<label for="change_order" class="col-sm-4 control-label">Change Order</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" class="form-control" id="change_order" name="change_order" placeholder="1234.56" value="{{ old('change_order', isset($project) ? $project->change_order : '') }}">
		</div>
	</div>
</div>
<hr>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note', isset($project) ? $project->note : '') }}</textarea>
	</div>
</div>

<hr>