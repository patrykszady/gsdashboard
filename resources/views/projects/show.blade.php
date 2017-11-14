@extends('main')

@section('title', $project->getProjectname())

@section('content')

<script type="text/javascript">

$(document).ready(function() {
    var dataTable = $('#expenses_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
      /*  "paging":   false,*/
        "stateDuration": 120,
        "sDom":     'ltipr',
        "columnDefs": [
			{ "searchable": false, "targets": 3 },
			{ "orderable": false, "targets": 3 }
		],
		"order": [[ 0, "desc" ]],
		"bLengthChange": false
    } );

    $("#filterbox_datatable").keyup(function() {
        dataTable.search(this.value).draw();
    });    
});

</script>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Project <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit Project</a> <a href="{{ route('clients.edit', $project->client->id) }}" class="btn btn-default">Edit Client</a></h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>
				<div class="col-xs-6">
					<p>
						<strong>Jobsite Address:</strong>
						<br>
						{!! $project->getFulladdress() !!}
					</p>
				</div>
				<div class="col-xs-6">
					<p>
						<strong>Billing Address:</strong>
						<br>
						{!! $project->client->getFulladdress() !!}
					</p>
				</div>
			
				<div class="col-md-12">
					@include('projects._statusform')
				</div>

			</div>

		</div>

	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Details</h3>
		  	</div>
			<div class="panel-body">
				
			
			
			<div class="col-md-6">
				<ul class="list-group">
					<li class="list-group-item">{{ money($expenses->sum('amount')) }} | Expenses</li>
					<li class="list-group-item">{{ money($project->hours->sum('amount')) }} | {{ $project->hours->sum('hours') }} Hours | Timesheets </li>
					<li class="list-group-item">{{ money($project->getTotalCost())}} | Total Cost</li>
					<hr>
					<li class="list-group-item">{{ money($project->getProfit()) }} | Profit</li>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="list-group">
					<li class="list-group-item">{{ money($project->project_total) }} | Project Estimate</li>
					<li class="list-group-item">{{ money($project->change_order) }} | Change Order</li>
					<li class="list-group-item">{{ money($project->getReimbursment()) }} | Reimbursment</li>
					<li class="list-group-item">{{ money($project->getProjectTotalFormat()) }} | Project Total</li>
				</ul>
			</div>
			</div>
		
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">

		<div class="panel-heading">Contacts <a href="{{ url('users/create', $project->client->id) }}" class="btn btn-default">Add Another</a></div>

		@include('users._table')
	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">Reimbursments <a href="{{ url('expenses/create') }}" class="btn btn-default">Add Another</a>
		<a href="{{ route('expenses.printReimbursment', $project->id) }}" class="btn btn-primary" target="_blank">Print Reimbursments</a>
		</div>
<table class="table table-striped table-hover">
	<thead>
		<th>Date</th>
		<th>Vendor</th>
		<th>Amount</th>
		<th>Receipt</th>
		<th>Actions</th>
	</thead>

	<tbody>
		
		@foreach ($reimbursment as $expense)

			<tr>
				<td>{{ $expense->getDate() }}</td>
				<td>
   					{{  $expense->vendor->business_name }}
				</td>
				<td>{{ money($expense->amount) }}</td>
				<td>
					@include('expenses._receipt_modal')
				</td>
				
				<td>
					<a href="{{ route('expenses.show', $expense->getId()) }}" class="btn btn-default">View</a>
					<a href="{{ route('expenses.edit', $expense->getId()) }}" class="btn btn-default">Edit</a>
				</td>
			</tr>

		@endforeach

	</tbody>
</table>


		


	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">Expenses <a href="{{ url('expenses/create') }}" class="btn btn-default">Add Another</a></div>
<table class="table table-striped table-hover">
	<thead>
		<th>Vendor</th>
		<th>Amount</th>
	</thead>

	<tbody>
		
		@foreach ($vendor_expenses as $expense)

			<tr>
				<td>
				<a href="{{ route('vendors.show', $expense->vendor->id)}}">{{ $expense->vendor->business_name }}</a>
				</td>

				<td>{{ $project->getVendortotal($expense->vendor_id) }}</td>
				
				{{-- <td>
					<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
				</td> --}}
			</tr>

		@endforeach

	</tbody>
</table>


		<!-- Table -->
		
<table class="table table-striped table-hover">
	<thead>
		<th>Employee</th>
		<th>Hours</th>
		<th>Amount</th>
	
	</thead>

	<tbody>
		
		@foreach ($timesheets as $employee)

			<tr>
				<td>
   					{{ $employee->user->first_name }}
				</td>

				<td>{{ $project->hours->where('user_id', $employee->user_id)->sum('hours') }}</td>
				<td>${{ $project->hours->where('user_id', $employee->user_id)->sum('amount') }}</td>
				{{-- <td>{{ $project->hours->where('user_id', $employee->user_id)->sum('hours') * $project->hours->where('user_id', $employee->user_id)->hourly }}</td> --}}
				{{-- <td>
					<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
				</td> --}}
			</tr>
		
		@endforeach
		<h3></h3>
	</tbody>
</table>


	</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		@include('expenses._table')
	</div>
</div>

@endsection

