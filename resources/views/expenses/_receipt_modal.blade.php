@if(isset($form_view))
@else
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-{{$expense->getId()}}">Receipt</button>
@endif

<div class="modal fade bs-example-modal-lg-{{$expense->getId()}}" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $expense->getAmount() . ' for ' . $expense->vendor->business_name}}</h4>
      </div>
      <div class="modal-body">
        @include('expenses._receipt')
      </div>
    </div>
  </div>
</div>