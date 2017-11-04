@extends('main')

@section('title', 'Create Contact')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Edit {{ $user->first_name }}</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="/users/{{$user->id}}" method="POST">
				{{ csrf_field() }}	
				{{ method_field('PATCH') }}
					
					@include('users._formedit')			
		
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success btn-block">Update Contact</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection