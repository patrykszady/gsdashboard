<table class="table table-striped table-hover">
<thead>
	<th>Date</th>
	<th>Amount</th>
	<th>Project</th>
	@if(isset($vendor))
	@else
	<th>Vendor</th>
	@endif

	<th>Balance</th>
</thead>

<tbody>
		
@foreach ($bids as $bid)

<tr>
	
	<td>{{ $bid->getDate() }}</td>
	<td>{{ $bid->getTotal() }}</td>
	<td>{{ $bid->project->getProjectname() }}</td>
	@if(isset($vendor))
	@else
	<td><a href="{{ route('vendors.show', $bid->vendor->id)}}">{{ $bid->vendor->business_name }}</a></td>
	@endif
	<td>{{ $bid->getBalance() }}</td>
	
	{{-- <td>
		<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-default">View</a>
		<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default">Edit</a>

	</td> --}}
</tr>

@endforeach

</tbody>
</table>