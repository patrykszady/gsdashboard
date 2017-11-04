@extends('main')

@section('title', 'Create Expense')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
{{-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
<script type="text/javascript">
  
$(window).load(function()
{
    $('#myModal').modal('show');
});
</script>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('expenses.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
				{{ csrf_field() }}

					@include('expenses._form')
					
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<button type="submit" name="another" value="another" class="btn btn-success btn-block">Another</button>
						</div>
						<div class="col-sm-2">
							<button type="submit" name="done" value="done" class="btn btn-default btn-block">Finished</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@if(isset($expenses))
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Recently Added Expenses</div>
			@include('expenses._table')
		</div>
	</div>
</div>
@endif

@endsection