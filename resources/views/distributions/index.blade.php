@extends('main')

@section('title', 'Distrbution Accounts')

@section('content')

<div class="row">

	<div class="col-md-10">
		<h1>All Distributions</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('distributions.create') }}" class="btn btn-lg btn-block btn-primary">New Account</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">
		@include('distributions._table')		
	</div>
	
</div>

@endsection