@extends('main')

@section('title', 'Clients')

@section('content')

<div class="row">

	<div class="col-md-10">
		<h1>All Contacts</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('users.create') }}" class="btn btn-lg btn-block btn-primary">New Contact</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">

		@include('users._table')
		
	</div>
	
</div>

@endsection