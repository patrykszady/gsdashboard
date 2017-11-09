@extends('main')

@section('title', 'Project Distributions')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
 
<script type="text/javascript">


$(document).ready(function() {

@foreach ($accounts as $key => $account)
var $output{{$key}} = $("#output-value{{$key}}");
$("#account{{$key}}").keyup(function() {
    var value = parseFloat($(this).val());
    $output{{$key}}.val(({{$project->getProfit()}}*(value*.01)).toFixed(2));
});

@endforeach    

});
</script>


<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('distributions.projectStore') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}

					@include('distributions._projectform')

					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success btn-block">Create Project Distribution</button>
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection