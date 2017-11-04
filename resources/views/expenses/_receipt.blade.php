@if(isset($expense->receipt_html))
<div class="row">
	@if(isset($expensesplit))
		<div class="col-md-12">
			<pre style="background-color:transparent">{!! $expense->receipt_html !!} </pre>
		</div>
  	@else
		<div class="col-md-8 col-md-offset-2">
			<pre style="background-color:transparent">{!! $expense->receipt_html !!} </pre>
		</div>
  	@endif
</div>
<div class="row">
  <div class="col-md-12">
    <h4>
      <a href="{{ route('expenses.original_receipt', $expense->receipt) }}" target="_blank">Original Receipt</a>
    </h4>
  </div>
</div>
@else
<a href="{{ route('expenses.receipt', $expense->receipt) }}" target="_blank"><img src="{{route('expenses.receipt', $expense->receipt)}}" class="img-responsive" alt="Expense Receipt"></a>
@endif