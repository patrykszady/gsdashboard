<div class="row">
	@if(isset($expense->receipt))
	<div class="col-md-5">
	@else
	<div class="col-md-6 col-md-offset-3">
	@endif
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
						<td>{{ $expense->expense_date->toFormattedDateString() }}</td>
					</tr>
					<tr>
						<td><strong>Amount</strong></td>
						<td>{{ money($expense->amount) }}</td>
					</tr>
					<tr>
						<td><strong>Vendor</strong></td>
						<td><a href="{{ route('vendors.show', $expense->vendor->id)}}">{{ $expense->vendor->getName() }}</a></td>
					</tr>
					<tr>
						@if(isset($expensesplit))

						@else

						@if(isset($expense->project_id))
							<td><strong>Project</strong></td>
							<td><a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a></td>
						@else
							<td><strong>Account</strong></td>
							<td><a href="{{ route('distributions.show', $expense->distribution->id) }}">{{$expense->distribution->name}}</a></td>
						@endif
						@endif
					</tr>
				</tbody>
			</table>
			@if(isset($existing_expense))
			@else
			<div class="panel-footer">
				<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
				<a href="{{ route('expensesplits.create', $expense->id) }}" class="btn btn-warning">Split</a>
		{{-- 		<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-danger">Delete</a> --}}
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
						<td><strong>Reimbursment</strong></td>
						<td>{{ $expense->getReimbursment() }}</td>
					</tr>
					<tr>
						<td><strong>Reference</strong></td>
						<td>{{ $expense->invoice }}</td>
					</tr>
					<tr>
						<td><strong>Check</strong></td>
						<td>
							@if(isset($expense->check_id))
							<a href="{{ route('checks.show', $expense->check_id) }}">{{ $expense->check->check }}</a>
							@endif
						</td>
					</tr>
					<tr>
						<td><strong>Entered By</strong></td>
						<td><a href="{{ route('users.show', $expense->created_by_user_id) }}">{{ $expense->getCreatedBy() }}</a> on {{$expense->updated_at->toFormattedDateString() }}</td>
					</tr>
					<tr>
						<td><strong>Notes</strong></td>
						<td>{{ $expense->note }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>


@if(isset($expense->receipt))

	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Receipt</h3>
		  	</div>
		  		@include('expenses._receipt')
		</div>
	</div>

@endif
</div> {{-- ROW DIV --}}