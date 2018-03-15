{{-- show only on desktops! --}}


@extends('main')

@section('title', 'Input Expenses')

@section('content')
<script type="text/javascript">

$(document).ready(function() {
  	//onload
    $('[class*="column_r_"]').hide(); //reimbursment column
    $('[class*="column_p_"]').hide(); //paid_by column

@foreach ($expenses as $key => $expense)

$("#project_id{{$key}}").change(function() {
	var val = $("#project_id{{$key}}").val();
	var key = {{$key}};

	if(val != "") {
		$("#paid_by{{$key}}").show(); //reimbursment column
    	$("#reimbursment{{$key}}").show(); //paid_by column
    	$("#tablerow{{$key}}").css('background-color', '#dced98');
	} else {
		$("#paid_by{{$key}}").hide(); //reimbursment column
    	$("#reimbursment{{$key}}").hide(); //paid_by column
    	$("#tablerow{{$key}}").css('background-color', 'inherit');
	}

});

@endforeach    

});

</script>

<form class="form-horizontal" action="{{ route('expenses.inputStore') }}" method="POST" autocomplete="off" >
	{{ csrf_field() }}
		
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Input Automated Receipts <button type="submit" class="btn btn-success">Save</button></div>
	<table id="expenses" class="table table-striped table-hover">
		<div>
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Vendor</th>
				<th>Project</th>
				<th width="10%">Paid By</th>
				<th width="10%">Reimbu rsment</th>
				<th>Actions</th>
			</tr>
		</thead>
		</div>
		<tbody>
		@foreach ($expenses as $key => $expense)
			<input name="expense_id[]" id="expense_id.$key" type="hidden" value="{{ old("expense_id.$key", $expense->id) }}">
		<tr id="tablerow{{$key}}">
			<td>
				{{ date_format($expense->expense_date,"m-d-y") }}
			</td>
			<td>
				{{ money($expense->amount) }}
			</td>
			<td>
				{{ $expense->vendor->getName() }}
			</td>
			<td> 
				<select class="form-control project_id.{{$key}}" id="project_id{{$key}}" name="project_id[]">
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
				<select class="form-control column_p_" id="paid_by{{$key}}" name="paid_by[]">
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
				<select class="form-control column_r_" id="reimbursment{{$key}}" name="reimbursment[]">
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
				@include('expenses._receipt_modal_input_view')
					<div class="btn-group">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg-{{$expense->getId()}}">Receipt</button>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="{{ route('expenses.show', $expense->id) }}">View</a></li>
							<li><a href="{{ route('expenses.edit', $expense->id) }}">Edit</a></li>
							<li><a href="{{ route('expenses.destroy', $expense->id) }}">Delete</a></li>
						</ul>
					</div>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
</form>
		</div>
	</div>

{{-- 	<div class="col-lg-1" style="position: sticky; top: 10px; position: -webkit-sticky;">
		<button type="submit" class="btn btn-success">Save</button>
	</div> --}}
</div>




@endsection