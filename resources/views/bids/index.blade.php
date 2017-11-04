@extends('main')

@section('title', 'Bids')

@section('content')

<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">Expenses <a href="{{ url('expenses/create') }}" class="btn btn-primary">New Expense</a></div>
			@include('bids._table')
		</div>
	</div>
{{-- 	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Timesheets <a href="{{ url('hours/create') }}" class="btn btn-primary">New Timesheet</a></div>
			@include('hours._table')
		</div>
	</div> --}}
</div>

@endsection