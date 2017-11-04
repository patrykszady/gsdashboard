<table class="table table-striped table-hover">
	<thead>
		<th>Proejct Name</th>
		<th>Total Paid</th>
		<th>Bid</th>
		<th>Balance Due</th>
	</thead>

	<tbody>
		
		@foreach ($projects as $project)
			<tr>
				<td><a href="{{ route('projects.show', $project->id)}}">{{ $project->getProjectname()  }}</td>
				<td>{{ $project->getBid($vendor) }}</td>
				<td>{{ $project->getTotal($vendor) }}</td>
				<td>{{ $project->getBidbalance($vendor)  }}</td>	
			</tr>
		@endforeach

	</tbody>
</table>