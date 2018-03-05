@extends('main')

@section('title', 'New Automatic Receipt')

@section('content')

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('receipts.store') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}

					@include('receipts._form')
					
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success btn-block">Add Auto Account</button>
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection