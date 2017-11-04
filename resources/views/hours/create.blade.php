@extends('main')

@section('title', 'Create Timesheet')

@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
   $('.box').change(function(){
       var total = 0;
       $('.box:checked').each(function(){
            total+=parseFloat($(this).attr("rel"));
       });
       $('#total').val(total.toFixed(2));
    });
});

$(document).ready(function() {

    $this = $(this);
    output = $this.find('option:selected').attr('rel');
    
    $("#output").val(output);

    $("#user_id").change(onSelectChange);

function onSelectChange(){
    
        $this = $(this);

        output = $this.find('option:selected').attr('rel');
    
        $("#output").val(output);
}
});

</script>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ route('hours.store') }}" method="POST" autocomplete="off">
				{{ csrf_field() }}
					@include('hours._form')
				</form>
			</div>
		</div>
	</div>
</div>

@endsection