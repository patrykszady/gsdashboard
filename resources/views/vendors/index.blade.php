@extends('main')

@section('title', 'Vendors')

@section('content')

<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#vendors_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
      /*  "paging":   false,*/
        "stateDuration": 120,
        "sDom":     'ltipr',
/*        "columnDefs": [
			{ "searchable": false, "targets": 3 },
			{ "orderable": false, "targets": 3 }
		],*/
		"order": [[ 0, "asc" ]],
		"bLengthChange": false
    } );

    $("#filterbox_datatable").keyup(function() {
        dataTable.search(this.value).draw();
    });    
});
</script>

<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
			Vendors <a href="{{ route('vendors.create') }}" class="btn btn-primary">New Vendor</a>
			</div>
				<div class="panel-body">
				<div>
					<ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#subs" aria-controls="subs" role="tab" data-toggle="tab">Sub Contractors</a></li>
					    <li role="presentation"><a href="#vendors" aria-controls="vendors" role="tab" data-toggle="tab">Vendors</a></li>
					</ul>

					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="subs">
					    	<hr>
							<form class="form" autocomplete="off">
								<div class="col-md-4">
								<div class="form-group">
									<label class="sr-only" for="filterbox_datatable">Search</label>
									<input type="text" class="form-control" id="filterbox_datatable" placeholder="Search">
								</div>
								</div>
							</form>
					    	@include('vendors._table', ['biz_type'=>'Sub'])
					    </div>
					    <div role="tabpanel" class="tab-pane" id="vendors">
					    	@include('vendors._table', ['biz_type'=>'Retail'])
					    </div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
