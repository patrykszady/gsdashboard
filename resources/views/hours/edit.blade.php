@extends('main')

@section('title', 'Edit Timesheet')

@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {

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
				<form class="form-horizontal" action="{{ route('hours.create') }}" method="POST">
                {{-- method update --}}
				{{ csrf_field() }}
					@include('hours._editform')
				</form>
			</div>
		</div>
	</div>
</div>

@endsection