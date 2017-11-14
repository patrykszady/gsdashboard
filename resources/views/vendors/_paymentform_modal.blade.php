<div class="modal fade bs-example-modal-md-{{$expense->id}}" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ money($expense->amount) . ' for ' . $expense->vendor->business_name }}</h4>
    </div>
    <div class="modal-body">
      @include('expenses._show')
    </div>
    </div>
  </div>
</div>