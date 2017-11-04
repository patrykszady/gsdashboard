@extends('main')

@section('title', $expense->vendor->getName())

@section('content')

	@if(empty($expense_splits[0]))
		@include('expenses._show')
	@else
		@include('expenses._show_splits')
	@endif

@endsection