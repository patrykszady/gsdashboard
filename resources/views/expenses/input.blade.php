@extends('main')

@section('title', 'Input Expenses')

@section('content')
<form class="form-horizontal" action="{{ route('expenses.inputStore') }}" method="POST" autocomplete="off" >
	{{ csrf_field() }}
		
<div class="row">
	<div class="col-lg-11">
		<div class="panel panel-default">
			<div class="panel-heading">Input Automated Receipts</div>
	<table id="expenses" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Project</th>
				<th>Vendor</th>
				<th width="15%">Paid By</th>
				<th width="15%">Reimbursment</th>
				<th width="10%">Receipt</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($expenses as $key => $expense)
			<input name="expense_id[]" id="expense_id.$key" type="hidden" value="{{ old("expense_id.$key", $expense->id) }}">
		<tr>
			<td>
				{{ $expense->getDate() }}
			</td>
			<td>
				{{ money($expense->amount) }}
			</td>
			<td> 
				<select class="form-control {{ $errors->has("project_id.$key") ? ' has-error' : '' }}" id="project_id.$key" name="project_id[]">
						<option value=""
							{{ old('project_id', isset($expense) ? $expense->project_id : '') == "" ? "selected" : "" }}>
							HINT: {{$expense->note}}
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
			</td>
			<td>
				{{ $expense->vendor->getName() }}
			</td>
			<td>
				<select class="form-control" id="paid_by.$key" name="paid_by[]">
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
			</td>
			<td>
				<select class="form-control" id="reimbursment.$key" name="reimbursment[]">
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
			</td>
			<td>
				@include('expenses._receipt_modal')
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</form>
		</div>
	</div>

	<div class="col-lg-1" style="position: sticky; top: 10px; position: -webkit-sticky;">
		<button type="submit" class="btn btn-success">Save</button>
	</div>
</div>



@endsection