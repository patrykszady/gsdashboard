<table class="table table-striped table-hover">
	<thead>
		<th>Name</th>
		<th>Billing Address</th>
		<th>Actions</th>
	</thead>

	<tbody>
		
		@foreach ($clients as $client)

			<tr>
				<td>

   					{{ $client->getName() }}
				</td>
				<td>{{ $client->getFulladdress1()}} <br> {{ $client->getFulladdress2()  }}</td>
				<td>
					<a href="{{ route('clients.show', $client->id) }}" class="btn btn-default">View</a>
					<a href="{{ route('clients.edit', $client->id) }}" class="btn btn-default">Edit</a>
				</td>
			</tr>

		@endforeach

	</tbody>
</table>