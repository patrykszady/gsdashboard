<div class="modal fade bs-example-modal-lg-{{$expense->id}}" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $expense->getAmount() . ' for ' }}</h4>
      </div>
      <div class="modal-body">
       	 <p>{!! $expense->receipt_html !!}</p>
      </div>
      	
    </div>
  </div>
</div>