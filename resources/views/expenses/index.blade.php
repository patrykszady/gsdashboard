@extends('main')

@section('title', 'Expenses')

@section('content')


@if($expense_input > 0)
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="alert alert-warning" role="alert">
				You have {{ $expense_input }} expensese to input! <a href="{{ url('expenses/input') }}" class="btn btn-warning">Input Expense</a>
			</div>
		</div>
	</div>
@endif

<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		@include('expenses._table')
	</div>
</div>

@endsection