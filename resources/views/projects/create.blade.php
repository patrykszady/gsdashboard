@extends('main')

@section('title', 'Create Project')

@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#row_dim").hide();
$('input[type="radio"]').click(function() {
  if ($(this).attr("value") == 2) {
    $("#row_dim").show();
  } else {
    $("#row_dim").hide();
  }
});
});


</script>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('projects.store') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}
		
					@include('projects._form')
					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-primary btn-block">Create</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>

@endsection