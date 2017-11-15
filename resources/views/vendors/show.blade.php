@extends('main')

@section('title', $vendor->business_name)

@section('content')

	@if(Auth::user()->primary_vendor == $vendor->id)
		@include('vendors._primary_show')
	{{-- IF vendor is a vendor NOT a sub show a different page...if employee, a different --}}
	@else
		@include('vendors._show_vendor')
	@endif

@endsection

