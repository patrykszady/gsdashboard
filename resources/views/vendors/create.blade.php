@extends('main')

@section('title', 'Create Vendor')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('vendors.store') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}
				
					@include('users._form')
					@include('vendors._form')
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success btn-block">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection