<div class="panel panel-default">
	<div class="panel-heading">
	<form class="form-inline" autocomplete="off">
		<div class="form-group">Expenses <a href="{{ url('expenses/create') }}" class="btn btn-primary">New Expense</a>
		</div>
		<div class="form-group">
			<label class="sr-only" for="filterbox_datatable">Search</label>
			<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
		</div>
  	</form>
	</div>
<table id="expenses_datatable" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Date</th>
			<th>Amount</th>
			
			@if(isset($project))
			@else
			<th>Project</th>
			@endif
			@if(isset($vendor))
			@else
			<th>Vendor</th>
			@endif
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
	@foreach ($expenses as $expense)
		<tr>
			<td data-order="{{$expense->expense_date}}">{{ $expense->getDate() }}</td>
			<td data-search="{{$expense->amount}}">{{ money($expense->amount) }}</td>

			@if(isset($project))
			@else
				@if($expense->project_id != 0)
					<td><a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a></td>
				@elseif(isset($expense->expense_splits) AND count($expense->expense_splits) > 0)
					<td><a href="{{ route('expenses.show', $expense->getId())}}">Expense Split</a></td>
				@elseif($expense->project_id == 0 AND $expense->distribution_id == NULL) 
					<td><a href="{{ route('expenses.show', $expense->getId())}}"><strong>Input Expense</strong></a></td>
				@else
					<td><a href="{{ route('distributions.show', $expense->distribution->id) }}">{{$expense->distribution->name}}</a></td>
				@endif
			@endif

			@if(isset($vendor))
			@else
				<td><a href="{{ route('vendors.show', $expense->vendor->id)}}">{{ $expense->vendor->getName() }}</a></td>
			@endif
	
			<td>
				<a href="{{ route('expenses.show', $expense->getId()) }}" class="btn btn-default">View</a>
				<a href="{{ route('expenses.edit', $expense->getId()) }}" class="btn btn-default">Edit</a>
			</td>
			
		</tr>
	@endforeach
	</tbody>
</table>
</div>