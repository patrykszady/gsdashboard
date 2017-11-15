<div class="panel panel-default">
	<div class="panel-heading">
	<form class="form-inline" autocomplete="off">
		<div class="form-group">Checks{{--  <a href="{{ route('clients.create') }}" class="btn btn-primary">New Client</a> --}}
		</div>
		<div class="form-group">
			<label class="sr-only" for="filterbox_datatable">Search</label>
			<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
		</div>
  	</form>
	</div>

<table class="table table-striped table-hover" id="checks_datatable">
	<thead>
		<th>Date</th>
		<th>Check</th>
		<th>Amount</th>
		<th>Payee</th>
	</thead>
	<tbody>	
		@foreach ($checks as $check)
		{{dd($check->expenses()->get()) }}
			<tr>
				<td>{{ $check->getDate() }}</td>
				<td><a href="{{ route('checks.show', $check->check)}}">{{ $check->check }}</td>
				<td data-search="{{$check->getTotal()}}">{!! money($check->getTotal()) !!}</td>
				{{--  --}}
				@if(isset($check->getPayee()->first_name))
					<td><a href="{{ route('users.show', $check->getPayee()->id)}}"> {{ $check->getName()}}</td>
       	 		@elseif (isset($check->getPayee()->business_name))
           			<td><a href="{{ route('vendors.show', $check->getPayee()->id)}}"> {{ $check->getName()}}</td>
            	@endif	
			</tr>
		@endforeach
	</tbody>
</table>
</div>