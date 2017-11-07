<table class="table table-striped table-hover">
	<thead>
		<th>Proejct Name</th>
		<th>Client</th>
		<th>Total Cost</th>
		<th>Actions</th>
	</thead>

	<tbody>
		
		@foreach ($projects as $project)

			<tr>
				<td><a href="{{ route('projects.show', $project->id)}}">{{ $project->getProjectname() }}</a></td>
				<td><a href="{{ route('clients.show', $project->client->id)}}">{{ $project->client->getName() }}</a></td>
				<td>{{ money($project->getTotalCost()) }} </td>

				<td>
					<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
				</td>
			</tr>

		@endforeach

	</tbody>
</table>