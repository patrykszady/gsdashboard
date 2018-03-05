{{-- <div class="form-group {{ $errors->has('amount') ? ' has-error' : ''}}">
	<label for="amount" class="col-sm-4 control-label">Amount</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" class="form-control" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}">
		</div>
	</div>
</div> --}}

<div class="form-group {{ $errors->has('project_id') ? ' has-error' : ''}}">
	<label for="project_id" class="col-sm-4 control-label">Project</label>
	<div class="col-sm-6">
		<select class="form-control" id="project_id" name="project_id">
				<option value="0"  
					{{ old('project_id', isset($expense) ? $expense->project_id : '') == "" ? "selected" : "" }}>Find Automatically 
				</option>

			@foreach ($projects as $project)
				<option value="{{$project->id}}" 
					{{ old('project_id', isset($expense->project_id) ? $expense->project_id : '') == $project->id ? "selected" : "" }}>
					{{ $project->getProjectname() }}
				</option>
			@endforeach

			<option value="" disabled>ACCOUNTS</option>

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
	<label for="mailbox" class="col-sm-4 control-label">Mailbox</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="mailbox" placeholder="INBOX/Home Depot" name="mailbox" value="{{ old('mailbox', isset($receipt) ? $receipt->mailbox : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="from_address" class="col-sm-4 control-label">From Address</label>
	<div class="col-sm-6">
		<input type="email" class="form-control" id="from_address" placeholder="receipts@homedepot.com" name="from_address" value="{{ old('from_address', isset($receipt) ? $receipt->from_address : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="receipt_type" class="col-sm-4 control-label">Receipt Type</label>
	<div class="col-sm-6">
		<select class="form-control" id="receipt_type" name="receipt_type">
			<option value="1" {{ old('receipt_type', isset($receipt) ? $receipt->receipt_type : '') == 0 ? "selected" : "" }}>Sales Receipt</option>
			<option value="2" {{ old('receipt_type', isset($receipt) ? $receipt->receipt_type : '') == "2" ? "selected" : "" }}>Return Receipt</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label for="attached_receipt" class="col-sm-4 control-label">Receipt Attachment</label>
	<div class="col-sm-6">
		<select class="form-control" id="attached_receipt" name="attached_receipt">
			<option value="1" {{ old('attached_receipt', isset($receipt) ? $receipt->attached_receipt : '') == 0 ? "selected" : "" }}>Yes</option>
			<option value="2" {{ old('attached_receipt', isset($receipt) ? $receipt->attached_receipt : '') == "2" ? "selected" : "" }}>No</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label for="receipt_filename" class="col-sm-4 control-label">Receipt Filename</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="receipt_filename" placeholder="eReceipt.pdf" name="receipt_filename" value="{{ old('receipt_filename', isset($receipt) ? $receipt->receipt_filename : '') }}">
	</div>
</div>

<hr>

<div class="form-group">
	<label for="receipt_start" class="col-sm-4 control-label">Receipt Start</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="receipt_start" placeholder="</span></div>" name="receipt_start" value="{{ old('receipt_start', isset($receipt) ? $receipt->receipt_start : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="receipt_end" class="col-sm-4 control-label">Receipt End</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="receipt_end" placeholder="</span></div>" name="receipt_end" value="{{ old('receipt_end', isset($receipt) ? $receipt->receipt_end : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="amount_start" class="col-sm-4 control-label">Amount Start</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="amount_start" placeholder="</span></div>" name="amount_start" value="{{ old('amount_start', isset($receipt) ? $receipt->amount_start : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="amount_end" class="col-sm-4 control-label">Amount End</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="amount_end" placeholder="</span></div>" name="amount_end" value="{{ old('amount_end', isset($receipt) ? $receipt->amount_end : '') }}">
	</div>
</div>

<hr>

<div class="form-group">
	<label for="po" class="col-sm-4 control-label">PO Attached?</label>
	<div class="col-sm-6">
		<select class="form-control" id="po" name="po">
			<option value="1" {{ old('po', isset($receipt) ? $receipt->po : '') == "1" ? "selected" : "" }}>Yes, Find PO</option>
			<option value="2" {{ old('po', isset($receipt) ? $receipt->po : '') == "2" ? "selected" : "" }}>No PO</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label for="po_start" class="col-sm-4 control-label">PO Start</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="po_start" placeholder="</span></div>" name="po_start" value="{{ old('po_start', isset($receipt) ? $receipt->po_start : '') }}">
	</div>
</div>

<div class="form-group">
	<label for="po_end" class="col-sm-4 control-label">PO End</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="po_end" placeholder="</span></div>" name="po_end" value="{{ old('po_end', isset($receipt) ? $receipt->po_end : '') }}">
	</div>
</div>


@if(isset($receipt))

<input type="hidden" name="receipt_id" value="{{$receipt->id}}">

@endif