<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#expenses_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
      /*  "paging":   false,*/
      	"pageLength": 5,
        "stateDuration": 120,
        "sDom":     'ltipr',
/*        "columnDefs": [
			{ "searchable": false, "targets": 3 },
			{ "orderable": false, "targets": 3 }
		],*/
		"order": [[ 0, "desc" ]],
		"bLengthChange": false
    } );

    $("#filterbox_datatable").keyup(function() {
        dataTable.search(this.value).draw();
    });    
});
</script>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Vendor <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-default">Edit Vendor</a></h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>
				<p>
					<strong>Address:</strong>
					<br>
					{!! $vendor->getFulladdress() !!}
				</p>
				@if(isset($vendor->biz_phone))
					<p>
					<strong>Phone:</strong>
					<br>
					{{$vendor->biz_phone}}
				</p>
				@endif
				<br>
				<a href="{{ url('vendors/payment', $vendor->id) }}" class="btn btn-primary">Pay</a>
				<a href="{{ url('bids/create', $vendor->id) }}" class="btn btn-primary">Add Bids</a>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Contacts <a href="{{url('users/create', $vendor->id) }}" class="btn btn-default">Add Another</a></div>
			@include('users._table')
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
{{-- 		<div class="panel-heading">
			Projects With Balance
		</div>
			@include('projects._tablevendor') --}}
			<div class="panel-heading">
				Projects with Balance
			</div>
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
		@include('checks._table')
	</div>
</div>