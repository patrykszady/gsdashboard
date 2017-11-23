@extends('main')

@section('title', 'Pay ' . $vendor->business_name )

@section('content')

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form class="form-horizontal" action="{{ route('vendors.payment') }}" method="POST" autocomplete="off">
		{{ csrf_field() }}
			@include('vendors._paymentform')
		</form>
	</div>
</div>

@endsection