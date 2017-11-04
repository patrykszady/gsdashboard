<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">

		<div class="panel-heading">Checks</div>
<table class="table table-striped table-hover">
<thead>
	<th>Date</th>
	<th>Check</th>
	<th>Amount</th>
	<th>Vendor</th>
	<th>Actions</th>
</thead>

<tbody>
		
@foreach ($checks as $check)

<tr>
	
	<td>{{ $check->getDate() }}</td>
	<td><a href="{{ route('expenses.check', $check->check)}}">{{ $check->check }}</a></td>
	<td>${{ $check->where('check', $check->check)->sum('amount') }}</td>
	<td><a href="{{ route('vendors.show', $check->vendor->id)}}">{{ $check->vendor->business_name }}</a></td>
	{{-- <td>${{ $expense->amount }}</td>
	@if(isset($project))
	@else
	<td><a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a></td>
	@endif
	<td><a href="{{ route('vendors.show', $expense->vendor->id)}}">{{ $expense->vendor->business_name }}</a></td>
	<td>
		<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-default">View</a>
		<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default">Edit</a>

	</td> --}}
</tr>

@endforeach

</tbody>
</table>



	</div>
	</div>
</div>