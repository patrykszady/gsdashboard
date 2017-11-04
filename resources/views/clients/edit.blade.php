@extends('main')

@section('title', 'Edit ' . $client->getName())

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="/clients/{{$client->id}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
					@include('clients._formedit')

{{-- 					@foreach ($client->users as $value => $user)
					
	
						@include('users._formedit', compact('user', 'value'))
					@endforeach
 --}}
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success btn-block">Update Client</button>
					</div>
	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection