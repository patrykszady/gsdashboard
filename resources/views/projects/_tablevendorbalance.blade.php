<table class="table table-striped table-hover">
	<thead>
		<th>Proejct Name</th>
		<th>Total Paid</th>
		<th>Bid</th>
		<th>Balance Due</th>
	</thead>

	<tbody>
		
		@foreach ($balances as $project)
			@if($project->getBidbalance($vendor) != '$0')
			<tr>
				<td><a href="{{ route('projects.show', $project->id)}}">{{ $project->getProjectname()  }}</td>
				<td>{{ $project->getTotal($vendor) }}</td>
				<td>{{ $project->getBid($vendor) }}</td>
				<td>{{ $project->getBidbalance($vendor)  }}</td>
			</tr>
			@endif
		@endforeach

	</tbody>
</table>