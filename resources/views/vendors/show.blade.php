@extends('main')

@section('title', $vendor->business_name)

@section('content')

	@if(Auth::user()->primary_vendor == $vendor->id)
		@include('vendors._primary_show')
	@else
		@include('vendors._vendor_show')
	@endif

@endsection

