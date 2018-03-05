<div class="form-group {{ $errors->has('project_id') ? ' has-error' : ''}}">
	<label for="project_id" class="col-sm-4 control-label">Account</label>
	<div class="col-sm-6">
		<select class="form-control" id="project_id" name="project_id">
			<option value="0"  
				{{ old('project_id', isset($expense) ? $expense->project_id : '') == "" ? "selected" : "" }}>Enter Project Manually</option>
			@foreach ($distributions as $distribution)
				<option value="A:{{$distribution->id}}" 
					{{ old('project_id', isset($expense->distribution_id) ? 'A:' . $expense->distribution_id : '') == 'A:' . $distribution->id ? "selected" : ""}}>
					{{ $distribution->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group {{ $errors->has('vendor_id') ? ' has-error' : ''}}">
	<label for="vendor_id" class="col-sm-4 control-label">Vendor</label>
	<div class="col-sm-6">
		<div class="input-group">
			<select class="form-control" id="vendor_id" name="vendor_id">
				<option value="" disabled 
					{{ old('vendor_id', isset($expense) ? $expense->vendor_id : '') == "" ? "selected" : "" }}>
					None
				</option>
				@foreach ($vendors as $vendor)
					<option value="{{$vendor->id}}" 
						{{ old('vendor_id', isset($expense) ? $expense->vendor_id : '') == $vendor->id ? "selected" : "" }}>
						{{ $vendor->getName() }}
					</option>
				@endforeach
			</select>
			<span class="input-group-btn">
				<a href="{{ route('vendors.create') }}" class="btn btn-primary">New</a>
			</span>
		</div>
	</div>	
</div>

<div class="form-group">
	<label for="from_address" class="col-sm-4 control-label">From Address</label>
	<div class="col-sm-6">
		<input type="email" class="form-control" id="from_address" placeholder="receipts@homedepot.com" name="from_address" value="{{ old('from_address', isset($receipt) ? $receipt->from_address : '') }}">
	</div>
</div>

@if(isset($receipt))

<input type="hidden" name="receipt_id" value="{{$receipt->id}}">

@endif