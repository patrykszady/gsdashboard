<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Vendor</h3>
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
			<div class="panel-heading">Contacts <a href="{{ url('users/create', $vendor->id) }}" class="btn btn-default">Add Another</a></div>

			@include('users._table')
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Active Projects <a href="{{ url('vendors/payment', $vendor->id) }}" class="btn btn-primary">Pay</a> <a href="{{ url('bids/create', $vendor->id) }}" class="btn btn-primary">Add Bids</a></div>
			@include('projects._tablevendor')
		<div class="panel-heading">Projects with Balance</div>
			@include('projects._tablevendorbalance')
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		@include('expenses._table') {{-- @include('expenses._table', $expenses = $expensess) --}}
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Checks</div>
			@include('checks._table')
		</div>
	</div>
</div>