@extends('main')

@section('title', 'Create Split Expense')

@section('content')

<div class="col-md-7" style="position: sticky; top: 10px;">
	@include('expenses._show', compact($expensesplit))
</div>

<form class="form-horizontal" action="{{ route('expensesplits.store') }}" method="POST" autocomplete="off"> 
	{{ csrf_field() }}
	<input type="hidden" name="expense_id" value="{{ $expense->id }}">


<div class="col-md-3">
<div class="row">
	<div id="sections">
		@if(old() == true)
			<?php $count = count(old('amount')); ?>
		@else
			<?php $count = 2; ?>
		@endif

		@for($i = 0; $i < $count; ++$i)
		  	<div class="section">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Split</h3>
					  	</div>
						<div class="panel-body">
			    			<fieldset>
			       				@include('expensesplits._form')
			    			</fieldset>
		 				</div>
		 				<div class="panel-footer">
							<a href="" class='btn btn-primary addsection'>Add Split</a>
							<a href="" class='btn btn-default remove'>Remove Split</a>
						</div>
					</div>
				</div>
			</div>
		@endfor
	</div>
</div>
</div>
 
<div class="row">
<div class="col-md-2" style="position: sticky; top: 10px; position: -webkit-sticky;">

	<div class="form-group">
	<div class="col-sm-12">
		
		<div class="form-group">
{{-- 	<label for="amount" class="col-sm-4 control-label">Total</label> --}}
	<div class="col-sm-12">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			<input type="text" disabled class="form-control" id="inputTotal" name="inputTotal" value="">
		</div>
	</div>
</div>

		<button type="submit" class="btn btn-success btn-block">Split</button>
	</div>	
</div>
</div>
</div>

</form>


<script type="text/javascript">

$(document).ready(function() {
    //this calculates values automatically 
    calculateSum();
/*    $("#inputTotal").val({{$expense->amount}});
    calculateSum();*/
    $(".txt").on("keydown keyup", function() {
        calculateSum();
    });

    $("body").on('click', '.addsection', function() {
    $(".txt").on("keydown keyup", function() {
    calculateSum();
    });
   	});
     
});

function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txt").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
        	sum += parseFloat(this.value);

            $(this).css("border-color", "");
        }
        else if (this.value.length != 0){
            $(this).css("border-color", "");
        }
    });
 	
 	var bal = sum;
 	sum = {{$expense->amount}} - bal;
	$("#inputTotal").val(sum.toFixed(2));
}

</script>
@push('script')
	<script src="/js/app.js"></script>
@endpush
   
@endsection