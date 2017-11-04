<table class="table table-striped table-hover">
	<thead>
		<th>Date</th>
		<th>Check</th>
		<th>Amount</th>
		<th>Payee</th>
		<th>Actions</th>
	</thead>

	<tbody>	

		@foreach ($checks as $check)

		
			<tr>
				<td>{{ $check->getDate() }}</td>
				<td><a href="{{ route('checks.show', $check->check)}}">{{ $check->check }}</td>
				<td>{{ $check->getTotal($vendor = isset($vendor) ? $vendor : null)}}</td>

				@if(isset($check->getPayee()->first_name))
					<td><a href="{{ route('users.show', $check->getPayee()->id)}}"> {{ $check->getName()}}</td>
       	 		@elseif (isset($check->getPayee()->business_name))
           			<td><a href="{{ route('vendors.show', $check->getPayee()->id)}}"> {{ $check->getName()}}</td>
            	@endif	
			</tr>
		
		@endforeach
	</tbody>
</table>