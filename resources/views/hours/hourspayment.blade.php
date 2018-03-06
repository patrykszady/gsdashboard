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
<script type="text/javascript">
$(document).ready(function(){
$(function() {
  //onload
  if($('#paid_by').val() == '0') {
      $('#row_check').show();
      $('#row_reference').hide();
  } else {
      $('#row_check').hide(); 
      $('#row_reference').show();
  } 
  //on paid_by change
    $('#paid_by').change(function(){
        if($('#paid_by').val() == '0') {
            $('#row_check').show();
      		$('#row_reference').hide(); 
        } else {
            $('#row_check').hide(); 
      		$('#row_reference').show(); 
        } 
    });
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