@extends('main')

@section('title', $user->getFullname())

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Contact</h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>

				<p>
					<strong>Email:</strong>
					<br>
					{{$user->email}}
			
				</p>
				@if(isset($user->phone_number))
					<p>
					<strong>Cell Phone:</strong>
					<br>
					{{$user->phone_number}}
				</p>
				@endif

				<strong>Actions:</strong>
				<br>
				<a href="{{ route('users.edit', $user->id) }}" class="btn btn-default">Edit</a>
				

			</div>
		</div>

	
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Client</div>
{{-- 		<div class="panel-body">
		<p>...</p>
		</div> --}}

		<!-- Table -->
		@include('clients._table')
	</div>
	</div>
</div>


@endsection

