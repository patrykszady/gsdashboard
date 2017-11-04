@extends('main')

@section('title', 'Update Expense')

@section('content')
<div class="row">
	@if(empty($expense_splits[0]))
		@include('expenses._edit')
	@else
		@include('expenses._edit_splits')
	@endif
</div>

@endsection