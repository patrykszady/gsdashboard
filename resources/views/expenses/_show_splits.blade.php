<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Expense</h3>
		  	</div>
			<div class="panel-body">
				
			</div>
			<table class="table table-hover">
				<tbody>
					<tr>
						<td width="35%"><strong>Date</strong></td>
						<td>{{ $expense->getDate() }}</td>
					</tr>
					<tr>
						<td><strong>Amount</strong></td>
						<td>{{ money($expense->amount) }}</td>
					</tr>
					<tr>
						<td><strong>Vendor</strong></td>
						<td><a href="{{ route('vendors.show', $expense->vendor->id)}}">{{ $expense->vendor->getName() }}</a></td>
					</tr>
				</tbody>
			</table>
			@if(isset($expense_splits))
			<div class="panel-footer">
				{{-- <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a> --}}
				<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit Expense</a>
				<a href="{{ route('expensesplits.create', $expense->id) }}" class="btn btn-warning">Edit Split</a>
				<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-danger">Delete</a>
			</div>
			@else
			<div class="panel-footer">
				<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
				<a href="{{ route('expensesplits.create', $expense->id) }}" class="btn btn-warning">Split</a>
				<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-danger">Delete</a>
			</div>
			@endif
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Details</h3>
		  	</div>
			<table class="table table-hover">
				<tbody>
					<tr>
						<td width="35%"><strong>Paid By</strong></td>
						<td>{{ $expense->getPaidBy() }}</td>
					</tr>
					<tr>
						<td><strong>Reference</strong></td>
						<td>{{ $expense->invoice }}</td>
					</tr>
					<tr>
						<td><strong>Check</strong></td>
						<td><a href="{{ route('checks.show', $expense->check_id)}}">{{ $expense->check_id }}</a></td>
					</tr>
					<tr>
						<td><strong>Created By</strong></td>
						<td><a href="{{ route('users.show', $expense->created_by_user_id)}}">{{ $expense->getCreatedBy() }}</a></td>
					</tr>
					<tr>
						<td><strong>Notes</strong></td>
						<td>{{ $expense->note }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		@if(isset($expense->receipt)) {{-- WILL NEVER HAPPEN receipt is always attached in this view --}}
			<div class="panel panel-default">
				<div class="panel-heading">
			    	<h3 class="panel-title">Receipt</h3>
			  	</div>
			  		@include('expenses._receipt')
			</div>
		@endif
	</div>

	<div class="col-md-6" style="position: sticky; top: 10px;">
@foreach($expense_splits as $expense_split)
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Split</h3>
	  	</div>
		<table class="table table-hover">
			<tbody>
				<tr>
					<td width="35%"><strong>Amount</strong></td>
					<td>{{ $expense_split->getAmount() }}</td>
				</tr>
				<tr>
					@if (isset($expense_split->project_id))
					<td><strong>Project</strong></td>
					<td><a href="{{ route('projects.show', $expense_split->project->id)}}">{{ $expense_split->project->getProjectname() }}</a></td>
					@else
					<td><strong>Account</strong></td>
					<td><a href="{{ route('distributions.show', $expense_split->distribution->id) }}">{{$expense_split->distribution->name}}</a></td>
					@endif
				</tr>
				<tr>
					<td><strong>Reimbursment</strong></td>
					<td>{{ $expense_split->getReimbursment() }}</td>
				</tr>
				<tr>
					<td><strong>Created By</strong></td>
					<td><a href="{{ route('users.show', $expense_split->created_by_user_id)}}">{{ $expense_split->getCreatedBy() }}</a></td>
				</tr>
				<tr>
					<td><strong>Notes</strong></td>
					<td>{{ $expense_split->note }}</td>
				</tr>
			</tbody>
		</table>
	</div>
@endforeach
</div>
</div> {{-- ROW DIV --}}

