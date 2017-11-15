<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Company</h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>
				<p>
					<strong>Address:</strong>
					<br>
					{{$vendor->getFulladdress1()}}
					<br>
					{{$vendor->getFulladdress2()}}
				</p>
				@if(isset($vendor->biz_phone))
					<p>
					<strong>Phone:</strong>
					<br>
					{{$vendor->biz_phone}}
				</p>
				@endif
				<strong>Actions:</strong>
				<br>
				<a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-default">Edit</a>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Employees <a href="{{ url('users/create', $vendor->id) }}" class="btn btn-default">Add Another</a></div>

			@include('users._table')
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		@include('projects._table', ['title'=>'Active Projects'])
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Timesheets <a href="{{ url('hours/create') }}" class="btn btn-primary">New Timesheet</a></div>
<table class="table table-striped table-hover">
<thead>
	<th>Employee</th>
	<th>Balance</th>
	<th>Actions</th>
</thead>

<tbody>

@foreach ($users as $user)
<tr>
	{{--  if Year is current, dont show, if it's past or future show--}}
	
	<td><a href="{{ route('users.show', $user->id)}}">{{ $user->first_name }}</a></td>
	<td><strong>{{ $user->getEmployeeBalance()}}</td>
	
	<td>
		<a href="{{ url('hours/payment', $user->id) }}" class="btn btn-default">Pay</a>
		{{-- <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default">Edit</a>
 --}}
	</td>
</tr>

@endforeach

</tbody>
</table>
		</div>
	</div>
</div>

