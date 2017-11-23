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
			<tr>
				<td data-order="{{$check->date}}">{{ $check->getDate() }}</td>
				<td><a href="{{ route('checks.show', $check->id)}}">{{ $check->check }}</a></td>
				<td data-search="{{$check->getTotal(isset($vendor) ? $vendor : '')}}">{!! money($check->getTotal(isset($vendor) ? $vendor : '')) !!}</td>
				<td><a href="{{ $check->getPayeeRoute() }}"> {{ $check->getName()}}</a></td>
			</tr>
		@endforeach
	</tbody>
</table>
</div>