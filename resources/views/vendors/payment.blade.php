@extends('main')

@section('title', 'Pay ' . $vendor->business_name )

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">

				<form class="form-horizontal" action="{{ route('vendors.payment') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}

				@include('vendors._paymentform')
					
				</form>
			</div>
		</div>
	</div>
</div>

@endsection