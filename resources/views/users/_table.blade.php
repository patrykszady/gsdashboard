<table class="table table-striped table-hover">
	<thead>
		<th>Name</th>
		<th>Email</th>
		<th>Cell Phone</th>
		<th>Actions</th>
	</thead>
	<tbody>	
		@foreach ($users as $user)
			<tr>
				<td><a href="{{ route('users.show', $user->id)}}">{{ $user->getFullName() }}</a></td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->phone_number }}</td>
				<td>
					<div class="btn-group">
						<a href="{{ route('users.edit', $user->id) }}" class="btn btn-default">Edit</a>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="{{ route('users.show', $user->id) }}">View</a></li>
							
							@if(isset($client)) {{-- Show only from clients.show or if $client is present --}}
							<li role="separator" class="divider"></li>
							<li>
							<a href="{{ url('users/remove_from_client', $user->id) }}">Remove From Client</a>
							</li>
					        @endif

					        @if(isset($vendor)) {{-- Show only from vendors.show or if $client is present --}}
					        <li role="separator" class="divider"></li>
							<li>
							<a href="{{ url('users/remove_from_vendor', $user->id) }}">Remove From Vendor</a>
							</li>
					        @endif
							
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
	</tbody>
</table>