@extends('main')

@section('title', 'Expenses')

@section('content')
<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#expenses_datatable').DataTable( {                                                 
        "info":     false,
        "stateSave": true,
      /*  "paging":   false,*/
        "stateDuration": 120,
        "sDom":     'ltipr',
        "columnDefs": [
			{ "searchable": false, "targets": 4 },
			{ "orderable": false, "targets": 4 }
		],
		"order": [[ 0, "desc" ]],
		"bLengthChange": false
    } );

    $("#filterbox_datatable").keyup(function() {
        dataTable.search(this.value).draw();
    });    
});
</script>

@if($expense_input > 0)
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="alert alert-warning" role="alert">
				You have {{ $expense_input }} expensese to input! <a href="{{ url('expenses/input') }}" class="btn btn-warning">Input Expense</a>
			</div>
		</div>
	</div>
@endif

<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		@include('expenses._table')
	</div>
</div>

@endsection
{{-- @push('scripts')
<script>
$(function() {
    $('#expenses_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('expenses.anyData') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'expense_date', name: 'expense_date' },
            { data: 'project_id', name: 'project_id' },
            { data: 'vendor_id', name: 'vendor_id' },
            { data: 'amount', name: 'amount' }
        ]
    });
});
</script>
@endpush --}}