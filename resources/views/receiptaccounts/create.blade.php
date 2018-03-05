@extends('main')

@section('title', 'Automated Receipts')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Active Receipt Accounts</div>
	<table id="expenses" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Vendor</th>
				<th>Tracking</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($receipt_account_active as $receipt)
{{-- 		@foreach ($expenses as $key => $expense)
			<input name="expense_id[]" id="expense_id.$key" type="hidden" value="{{ old("expense_id.$key", $expense->id) }}"> --}}
		<tr>
			<td>
				{{ $receipt->vendor->business_name }}
			</td>
			<td>
				@foreach($receipts->where('vendor_id', $receipt->vendor_id) as $receipt_part)
					@if($receipt_part->receipt_type == 1)
						{{ "Purchases" }}
					@elseif($receipt_part->receipt_type == 2)
						{{ "Returns" }}
					@endif					
				@endforeach
				{{-- {{ money($expense->amount) }} --}}
			</td>
			<td>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-md-active-{{$receipt->id}}">Edit</button>

			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

		</div>
	</div>
</div>
		
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Avaliable Receipt Accounts</div>
	<table id="expenses" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Vendor</th>
				<th>Tracking</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($receipt_account_avaliable as $receipt)
		<tr>
			<td>
				{{ $receipt->vendor->business_name }}
			</td>
			<td>
				@foreach($receipts->where('vendor_id', $receipt->vendor_id) as $receipt_part)
					@if($receipt_part->receipt_type == 1)
						{{ "Purchases" }}
					@elseif($receipt_part->receipt_type == 2)
						{{ "Returns" }}
					@endif					
				@endforeach
				{{-- {{ money($expense->amount) }} --}}
			</td>
			<td>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-md-{{$receipt->id}}">Add</button>

<form class="form-horizontal" action="{{ route('receiptaccounts.store') }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
	<div class="modal fade bs-example-modal-md-{{$receipt->id}}" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{'Add ' . $receipt->vendor->business_name . ' Receipt Account ' }}</h4>
			</div>
			<div class="modal-body">
				{{-- @include('expenses._receipt') --}}
<div class="form-group {{ $errors->has('company_email_id') ? ' has-error' : ''}}">
	<label for="company_email_id" class="col-sm-4 control-label">Email Account</label>
	<div class="col-sm-6">
		
			<select class="form-control" id="company_email_id" name="company_email_id">
				@foreach ($company_emails as $company_email)
					<option value="{{$company_email->id}}" 
						{{ old('company_email_id', isset($company_email_id) ? $company_email->vendor_id : '') == $company_email->id ? "selected" : "" }}>
						{{ $company_email->email }}
					</option>
				@endforeach
			</select>
{{-- 			<span class="input-group-btn">
				<a href="{{ route('vendors.create') }}" class="btn btn-primary">New</a>
			</span> --}}
	
	</div>	
</div>
<div class="form-group {{ $errors->has('project_id') ? ' has-error' : ''}}">
	<label for="project_id" class="col-sm-4 control-label">Project</label>
	<div class="col-sm-6">
		<select class="form-control" id="project_id" name="project_id">
			<option value="0" 
				{{ old('project_id', isset($expense) ? $expense->project_id : '') == "0" ? "selected" : "0" }}>
				NONE
			</option>

			<option value="" disabled>ACCOUNTS</option>
			@foreach ($distributions as $distribution)
				<option value="A:{{$distribution->id}}" 
					{{ old('project_id', isset($expense->distribution_id) ? 'A:' . $expense->distribution_id : '') == 'A:' . $distribution->id ? "selected" : ""}}>
					{{ $distribution->name }}
				</option>

			@endforeach
			<option value="" disabled>PROJECTS</option>
			@foreach ($projects as $project)
				<option value="{{$project->id}}" 
					{{ old('project_id', isset($expense->project_id) ? $expense->project_id : '') == $project->id ? "selected" : "" }}>
					{{ $project->getProjectname() }}
				</option>
			@endforeach

		</select>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Add Account</button>
	</div>	
</div>
<input type="hidden" name="vendor_id" value="{{$receipt->vendor_id}}">
			</div>
		</div>
		</div>
	</div>
</form>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

		</div>
	</div>
</div>



@endsection