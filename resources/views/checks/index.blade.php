@extends('main')

@section('title', 'Checks')

@section('content')

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@include('checks._table')		
	</div>
</div>

@endsection


