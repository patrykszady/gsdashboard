{{-- show only on desktops! --}}

@extends('main')

@section('title', 'Input Expenses')

@section('content')
<script type="text/javascript">

$(document).ready(function() {
	    $('[class*="column_r_"]').hide(); //reimbursment column
    $('[class*="column_p_"]').hide(); //paid_by column

    var dataTable = $('.expense_input_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
        "paging":   false,
        "stateDuration": 120,
        "sDom":     'ltipr',
        "columnDefs": [
			{ "searchable": false, "targets": [3, 4] },
			{ "orderable": false, "targets": [3, 4] }
		],
		"order": [ 1, "asc" ]
    } );

    $("#filterbox_datatable").keyup(function() {
        dataTable.search(this.value).draw();
    });    

@foreach ($expenses as $key => $expense)

$("#project_id{{$key}}").change(function() {
	var val = $("#project_id{{$key}}").val();
	var key = {{$key}};

	if(val != "") {
		if(val == "SPLIT"){
		$("#paid_by{{$key}}").show(); //reimbursment column
    	$("#reimbursment{{$key}}").hide(); //paid_by column
		} else {
		$("#paid_by{{$key}}").show(); //reimbursment column
    	$("#reimbursment{{$key}}").show(); //paid_by column
		}
		$("#tablerow{{$key}}").css('background-color', '#dced98');	
	} else {
		$("#paid_by{{$key}}").hide(); //reimbursment column
    	$("#reimbursment{{$key}}").hide(); //paid_by column
    	$("#tablerow{{$key}}").css('background-color', 'initial');
	}

});

@endforeach    

});

</script>

<div class="row">
	<div class="col-lg-10 col-md-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="form-inline" autocomplete="off">
			<div class="form-group">Input Automated Receipts 
			</div>
			<div class="form-group">
				<label class="sr-only" for="filterbox_datatable">Search</label>
				<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
			</div>
	  	</div>
		</div>
	<form class="form-horizontal" action="{{ route('expenses.inputStore') }}" method="POST" autocomplete="off" >
	{{ csrf_field() }}
	
	<table class="table table-striped table-hover expense_input_datatable">
		<div>
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Vendor</th>
				<th>Project</th>
				<th>Actions</th>
			</tr>
		</thead>
		</div>
		<tbody>
		@foreach ($expenses as $key => $expense)

		<tr id="tablerow{{$key}}">
			<input name="expense_id[]" id="expense_id{{$key}}" type="hidden" value="{{$expense->id}}">
			<td>{{ date_format($expense->expense_date,"m/d/y") }}</td>
			<td><strong>{{ money($expense->amount) }}</strong></td>
			<td>{{ $expense->vendor->getName() }}</td>
			<td> 
				<select class="form-control project_id.{{$key}}" id="project_id{{$key}}" name="project_id[]">
						<option value=""
							{{ old('project_id', isset($expense) ? $expense->project_id : '') == "" ? "selected" : "" }}>
							HINT: {{$expense->note}}
						</option>
						<option value="SPLIT">
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
				<div class="form-group column_p_" id="paid_by{{$key}}">
    			<label for="paid_by1{{$key}}">Paid By:</label>
				<select class="form-control" id="paid_by1{{$key}}" name="paid_by[]">
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
				<div class="form-group column_r_" id="reimbursment{{$key}}">
    			<label for="paid_by1{{$key}}">Reimbursment:</label>
				<select class="form-control" id="reimbursment1{{$key}}" name="reimbursment[]">
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
							<li><a href="{{ route('expenses.show', $expense->getId()) }}">View</a></li>
							<li><a href="{{ route('expenses.edit', $expense->id) }}">Edit</a></li>
							<li><a href="{{ route('expenses.edit', $expense->id) }}">Delete</a></li>
						</ul>
					</div>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

			<div class="panel-footer">
			  	<button type="submit" class="btn btn-success btn-block">Save</button>
			</div>
			</form>
		</div> {{-- panel panel-default --}}
	</div>
</div>

{{-- 	<div class="col-lg-1" style="position: sticky; top: 10px; position: -webkit-sticky;">
		<button type="submit" class="btn btn-success">Save</button>
	</div>


 --}}


@endsection