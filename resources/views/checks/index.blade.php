@extends('main')

@section('title', 'Checks')

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Checks</div>
			@include('checks._table')
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