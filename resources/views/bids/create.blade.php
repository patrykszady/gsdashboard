@extends('main')

@section('title', 'Create Bid')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Create New Bid</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('bids.store') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}	
					
					@if(isset($vendor->id))
						@include('bids._multiform')
					@else
						@include('bids._form')
					@endif

					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-primary btn-block">Add Bid</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection