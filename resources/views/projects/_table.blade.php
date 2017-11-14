<div class="panel panel-default">
	<div class="panel-heading">
	<form class="form-inline" autocomplete="off">
		<div class="form-group">Projects <a href="{{ url('projects/create') }}" class="btn btn-primary">New Project</a>
		</div>
		<div class="form-group">
			<label class="sr-only" for="filterbox_datatable">Search</label>
			<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
		</div>
  	</form>
	</div>
<table class="table table-striped table-hover" id="projects_datatable">
	<thead>
		<th>Proejct Name</th>
		<th>Client</th>
		<th>Total Cost</th>
		<th>Total Project</th>
{{-- 		<th>Actions</th> --}}
	</thead>

	<tbody>
		
		@foreach ($projects as $project)

			<tr>
				<td><a href="{{ route('projects.show', $project->id)}}">{{ $project->getProjectname() }}</a></td>
				<td><a href="{{ route('clients.show', $project->client->id)}}">{{ $project->client->getName() }}</a></td>
				<td>{{ money($project->getTotalCost()) }} </td>
				<td>{{ money($project->getProjectTotal()) }} </td>
{{-- 
				<td>
					<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
				</td> --}}
			</tr>

		@endforeach

	</tbody>
</table>
</div>
