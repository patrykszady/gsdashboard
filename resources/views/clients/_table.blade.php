<div class="panel panel-default">
	<div class="panel-heading">
	<form class="form-inline" autocomplete="off">
		<div class="form-group">Clients <a href="{{ route('clients.create') }}" class="btn btn-primary">New Client</a>
		</div>
		<div class="form-group">
			<label class="sr-only" for="filterbox_datatable">Search</label>
			<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
		</div>
  	</form>
	</div>

<table class="table table-striped table-hover" id="clients_datatable">
	<thead>
		<th>Name</th>
		<th>Billing Address</th>
		<th>Total Spent</th>
{{-- 		<th>Actions</th> --}}
	</thead>

	<tbody>
		@foreach ($clients as $client)
			<tr>
				<td><a href="{{ route('clients.show', $client->id)}}">{{ $client->getName() }}</a></td>
				<td>{!! $client->getFulladdress() !!}</td>
				<td>{{ money($client->getClientTotal()) }}</td>
{{-- 				<td>
					<a href="{{ route('clients.show', $client->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('clients.edit', $client->id) }}" class="btn btn-default">Edit</a>
				</td> --}}
			</tr>
		@endforeach
	</tbody>
</table>
</div>