@extends('main')

@section('title', 'Clients')

@section('content')

<div class="row">

	<div class="col-md-10">
		<h1>All Clients</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('clients.create') }}" class="btn btn-lg btn-block btn-primary">New Client</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">
		@include('clients._table')		
	</div>
	
</div>

@endsection