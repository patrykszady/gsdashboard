<div class="form-group {{$errors->has('expense_date') ? ' has-error' : ''}}">
	<label for="expense_date" class="col-sm-4 control-label">Date</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="expense_date" name="expense_date" placeholder="{{ date('m/d/y') }}" value="{{ old('expense_date', isset($expense) ? $expense->expense_date->format('m/d/y') : '') }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group {{ $errors->has('amount') ? ' has-error' : ''}}">
	<label for="amount" class="col-sm-4 control-label">Amount</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" class="form-control" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}">
		</div>
	</div>
</div>

<div class="form-group {{ $errors->has('project_id') ? ' has-error' : ''}}">
	<label for="project_id" class="col-sm-4 control-label">Project</label>
	<div class="col-sm-6">
		<select class="form-control" id="project_id" name="project_id">
				<option value="" disabled 
					{{ old('project_id', isset($expense) ? $expense->project_id : '') == "" ? "selected" : "" }}>
					None
				</option>
				<option value="0" 
					{{ old('project_id', isset($expense) ? $expense->project_id : '') == "0" ? "selected" : "" }}>
					SPLIT EXPENSE
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

<div class="form-group {{ $errors->has('paid_by') ? ' has-error' : ''}}">
	<label for="paid_by" class="col-sm-4 control-label">Paid By</label>
	<div class="col-sm-6">
		<select class="form-control" id="paid_by" name="paid_by">
			{{-- Can we put old('paid_by') elsewhere? to clean up this view? --}}
			<option value="0" 
				{{ old('paid_by', isset($expense) ? $expense->paid_by : '') == "0" ? "selected" : "" }}>
				{{ $primary_vendor->getName() }}
			</option>
			@foreach ($employees as $employee)
			<option value="{{$employee->id}}" 
				{{ old('paid_by', isset($expense) ? $expense->paid_by : '') == $employee->id ? "selected" : "" }}>
				{{ $employee->first_name }}
			</option>
			@endforeach
{{-- 			<option value="vendor" 
				{{ old('paid_by', isset($expense) ? $expense->paid_by : '') == "vendor" ? "selected" : "" }}>
				Vendor
			</option> --}}
			<option value="" disabled>Contractors</option>
			@foreach ($vendors->where('biz_type', 1) as $vendor)
			<option value="V:{{$vendor->id}}" 
				{{ old('paid_by', isset($expense) ? $expense->paid_by : '') == 'V:' . $vendor->id ? "selected" : "" }}>
				{{ $vendor->getName() }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label for="reimbursment" class="col-sm-4 control-label">Reimbursment</label>
	<div class="col-sm-6">
		<select class="form-control" id="reimbursment" name="reimbursment">
			<option value="0" {{ old('reimbursment', isset($expense) ? $expense->reimbursment : '') == 0 ? "selected" : "" }}>None</option>
			<option value="Client" {{ old('reimbursment', isset($expense) ? $expense->reimbursment : '') == "Client" ? "selected" : "" }}>Client</option>
			<option value="" disabled>Contractors</option>
			@foreach ($vendors->where('biz_type', 1) as $vendor)
			<option value="{{$vendor->id}}" 
				{{ old('reimbursment', isset($expense) ? $expense->reimbursment : '') == $vendor->id ? "selected" : "" }}>
				{{ $vendor->getName() }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label for="invoice" class="col-sm-4 control-label">Reference</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="invoice" placeholder="2010" name="invoice" value="{{ old('invoice', isset($expense) ? $expense->invoice : '') }}">
	</div>
</div>

<div class="form-group {{ $errors->has('check_id') ? ' has-error' : ''}}">
	<label for="check_id" class="col-sm-4 control-label">Check #</label>
	<div class="col-sm-6">
		@if(isset($expense->check_id))
		<div class="input-group">
			<input type="number" disabled class="form-control" id="check_id" placeholder="1020" name="check_id" value="{{ old('check_id', isset($expense) ? $expense->check->check : '') }}">
			<span class="input-group-btn">
				<a href="{{ route('checks.show', $expense->check_id) }}" class="btn btn-primary">Edit</a>
			</span>
		</div>
		@else
		<input type="number" class="form-control" id="check_id" placeholder="1020" name="check_id" value="{{ old('check_id', isset($expense) ? $expense->check_id : '') }}">
		@endif
	</div>
</div>






@if(Session::has('receipt_img') or isset($expense->receipt))

<div class="form-group has-success">
	<label for="receipt_img" class="col-sm-4 control-label">Receipt</label>
	<div class="col-sm-6">
		<div class="input-group">
		    <div class="input-group-addon"><a href="" class="btn-link" data-toggle="modal" data-target=".bs-example-modal-lg-123">Uploaded</a></div>
			<input type="text" class="form-control" id="receipt_img" name="receipt_img" disabled value="Upload New Below">
			{{-- @include('expenses._receipt_modal', ['form_view' => 1]) --}}
			<div class="modal fade bs-example-modal-lg-123" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						{{--  <h4 class="modal-title">{{ money($expense->amount) . ' for ' . $expense->vendor->business_name}}</h4> --}}
						
					</div>
					<div class="modal-body">
						<a href="{{ route('expenses.receipt', Session::get('receipt_img')) }}" target="_blank"><img src="{{route('expenses.receipt', Session::get('receipt_img'))}}" class="img-responsive" alt="Expense Receipt"></a>
					{{-- @include('expenses._receipt') --}}
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
	
<div class="form-group {{ $errors->has('receipt') ? ' has-error' : ''}}">
	<label for="receipt" class="col-sm-4 control-label"></label>
	<div class="col-sm-6">
		<div class="input-group">
			<div class="input-group-addon">Upload New</div>
			<input type="file" class="form-control" id="receipt" name="receipt">
			<input type="hidden" class="form-control" id="receipt" name="receipt" value="1.jpg">
		</div>
	</div>
</div>
@else
<div class="form-group {{ $errors->has('receipt') ? ' has-error' : ''}}">
	<label for="receipt" class="col-sm-4 control-label">Receipt</label>
	<div class="col-sm-6">
		<input type="file" class="form-control" id="receipt" name="receipt">
	</div>
</div>
@endif

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-6">
		<textarea class="form-control" rows="3" id="note" name="note">{{ old('note', isset($expense) ? $expense->note : '') }}</textarea>
	</div>
</div>

@if(isset($expense))

<input type="hidden" name="expense_id" value="{{$expense->id}}">

@endif

{{-- @if(Session('existing_expense'))

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Duplicate Expense</h4>
			</div>
			<div class="modal-body">
				<h4>This expense already exists. <strong>Are you sure</strong> you want to save it?</h4>
				<button type="submit" name="duplicate" value="duplicate" class="btn btn-danger">Save Anyway</button>

				<button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Do Not Save</button>
				<hr>
				<h4>Matching Expense:</h4>

				@include('expenses._show', ['expense' => Session('existing_expense'), 'existing_expense' => 1])
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

@endif
 --}}
