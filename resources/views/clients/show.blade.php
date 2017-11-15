@extends('main')

@section('title', $client->getName())

@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Client</h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>

{{-- 				@if(isset($client->business_name))
					<p><strong>Contact:</strong>
					<br>
					<h4>{{$client->getUsernames()}}</h4>
					</p>
				@endif

 --}}
				<p>
					<strong>Address:</strong>
					<br>
					{!! $client->getFulladdress() !!}
				</p>
				@if(isset($client->home_phone))
					<p>
					<strong>Phone:</strong>
					<br>
					{{$client->home_phone}}
				</p>
				@endif
				<strong>Actions:</strong>
				<br>
				<a href="{{ route('clients.edit', $client->id) }}" class="btn btn-default">Edit</a>
				<a href="{{ route('projects.create', $client->id) }}" class="btn btn-success">New Project</a>
			</div>
		</div>
	</div>
	
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Contacts <a href="{{ route('users.create', $client->id) }}" class="btn btn-default">Add Another</a></div>
		@include('users._table')
		</div>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		@include('projects._table')
	</div>
</div>

@endsection

