@extends('main')

@section('title', 'Checks')

@section('content')
<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#checks_datatable').DataTable( {                                                 
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
	<div class="col-md-10 col-md-offset-1">
		@include('checks._table')		
	</div>
</div>

@endsection


