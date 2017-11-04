@extends('main')

@section('title', 'Timesheets')

@section('content')

<div class="row">

	<div class="col-md-10">
		<h1>All Timesheets</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('hours.create') }}" class="btn btn-lg btn-block btn-primary">New Timesheet</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">
{{-- 		@include('hours._table') --}}		
	</div>
</div>
{{-- 
@include('hours._checkstable')
 --}}
{{-- <div class="row">
	<div class="col-md-12">
		Check is null
		@include('hours._table1')		
	</div>
</div> --}}

@endsection