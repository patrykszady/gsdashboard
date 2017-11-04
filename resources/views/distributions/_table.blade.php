<table class="table table-striped table-hover">
<thead>
	<th>Name</th>
	<th>Balance</th>	
	<th>Actions</th>
</thead>

<tbody>
		
@foreach ($distributions as $distribution)

<tr>
	
	<td>{{ $distribution->name }}</td>
	<td>{{ $distribution->getBalance()}}</td>
	<td>
		<a href="{{ route('distributions.show', $distribution->id) }}" class="btn btn-default btn-xs">View</a>
		<a href="{{ route('distributions.edit', $distribution->id) }}" class="btn btn-default btn-xs">Edit</a>
	</td>
</tr>

@endforeach

</tbody>
</table>

<table class="table table-striped table-hover">
	<thead>
		<th>Project Name</th>
		@foreach ($distributions as $distribution)
			<th>{{ $distribution->name }}</th>
		@endforeach
		<th>Actions</th>
	</thead>

<tbody>
		
@foreach ($projects as $project)
<tr>
	<td>
		<a href="{{ url('distributions/project', $project->id) }}" >{{$project->getProjectname()}}</a>
	</td>
		@foreach($project->distributions as $distribution)

			<td>{{$project->getDistBalance($distribution)}} | {{$distribution->pivot->percent}} %</td>
		@endforeach
	<td>
		<a href="{{ route('distributions.show', $distribution->id) }}" class="btn btn-default">View</a>
		<a href="{{ route('distributions.edit', $distribution->id) }}" class="btn btn-default">Edit</a>
	</td>
</tr>
@endforeach

</tbody>
</table>