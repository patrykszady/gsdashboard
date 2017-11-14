@extends('main')

@section('title', 'Projects')

@section('content')
<script type="text/javascript">

$(document).ready(function() {
    var dataTable = $('#projects_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
      /*  "paging":   false,*/
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
	<div class="col-lg-10 col-lg-offset-1">
		@include('projects._table')
	</div>
</div>

@endsection