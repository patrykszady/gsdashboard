@extends('main')

@section('title', 'Pay ' . $user->first_name )

@section('content')

<script type="text/javascript">

$(document).ready(function() {
  
       var total = 0;
       $('.box:checked').each(function(){
            total+=parseFloat($(this).attr("rel"));
       });
       $('#total').val(total.toFixed(2));
    });

$(document).ready(function() {
   $('.box').change(function(){
       var total = 0;
       $('.box:checked').each(function(){
            total+=parseFloat($(this).attr("rel"));
       });
       $('#total').val(total.toFixed(2));
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
				<form class="form-horizontal" action="{{ route('hours.payment') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}

				@include('hours._formpayment')
					
				</form>
			</div>
		</div>
	</div>
</div>

@endsection