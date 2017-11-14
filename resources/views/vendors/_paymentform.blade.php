<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<input name="vendor_id" type="hidden" value="{{ $vendor->id }}">
<div class="vendor_accounts">

@foreach ($projects as $key => $project)

<?php $key = $key-1; ?>

<h4>{{$project->getProjectname()}}</h4>

<div class="form-group counts">
  <div class="col-sm-4">
  <div class="input-group {{ $errors->has("bid.$key") ? ' has-error' : '' }}">
  <div class="input-group-addon">Bid</div>
    <input type="text" class="form-control bid" id="bid.$key" placeholder="1200" name="bid[]" value="{{ old("bid.$key", $project->bids->where('vendor_id', $vendor->id)->sum('amount')) }}">
  </div>
  </div>



  <div class="col-sm-4">

    <div class="input-group {{ $errors->has("amount.$key")  ? ' has-error' : '' }}">

  <div class="input-group-addon">Payment</div>
    <input type="text" class="form-control payment" id="$amount.$key" name="amount[]" value="{{ old("amount.$key") }}">
   
  </div>
  </div>

  <div class="col-sm-4">
  <div class="input-group">
  <div class="input-group-addon">Balance</div>
    <input type="text" disabled class="form-control balance" id="balance.$key" placeholder="1200" name="balance[]" value="{{$project->bids->where('vendor_id', $vendor->id)->sum('amount') - $project->expenses->where('vendor_id', $vendor->id)->sum('amount') }}">
  </div>
  <input type="hidden" class="form-control current_balance" value="{{$project->expenses->where('vendor_id', $vendor->id)->sum('amount')}}">
  </div>

</div>
  <input name="project_id[]" id="project_id.$key" type="hidden" value="{{$project->id}}">
<hr>

@endforeach

</div>

<div class="panel panel-default">
<!-- Default panel contents -->
  <div class="panel-heading">Expenses {{$vendor->business_name}} paid for</div>

<!-- List group -->
@foreach ($expensess as $expense)

  <ul class="list-group">
    <li class="list-group-item">
    <input class="box" type="checkbox" value="{{$expense->id}}" name="expense[]" rel="{{$expense->amount}}"
    {{ !empty(old('expense')) && (in_array($expense->id, old('expense'))) ? 'checked' : '' }}
    >&nbsp;&nbsp;&nbsp;&nbsp;

    <strong>{{ money($expense->amount) }} </strong> 
    
    {{'paid for ' . $expense->vendor->business_name . ' on ' . $expense->getDate() . ' for project ' }}
    @if (isset($expense->project_id))
      <a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a>
    @else
      <a href="{{ route('distributions.show', $expense->distribution->id) }}">{{$expense->distribution->name}}</a>
    @endif
    </li>
  </ul>
@endforeach

</div>

<div class="panel panel-default">
<!-- Default panel contents -->
  <div class="panel-heading">Expenses GS Construction Paid For</div>

    <!-- List group -->
    @foreach ($expensesss as $expense)
      @include('vendors._paymentform_modal')

      <ul class="list-group">
        <li class="list-group-item">
        <input class="box" type="checkbox" value="{{$expense->id}}" name="expense_by_primary_vendor[]" rel="-{{$expense->amount}}" 
        {{ !empty(old('expense_by_primary_vendor')) && (in_array($expense->id, old('expense_by_primary_vendor'))) ? 'checked' : '' }}
        >&nbsp;&nbsp;&nbsp;&nbsp;

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-md-{{$expense->id}}"><strong>-{{ money($expense->amount) }} </strong></button>


        {{'paid for ' . $expense->vendor->business_name . ' on ' . $expense->getDate() . ' for project ' }}
        @if (isset($expense->project_id))
          <a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a>
        @else
          <a href="{{ route('distributions.show', $expense->distribution->id) }}">{{$expense->distribution->name}}</a>
        @endif
        </li>
      </ul>

    @endforeach

</div>

    <input type="hidden" id="checkTotal" name="check" value="">

    <input type="hidden" id="inputTotal" name="check1" value="">

  <hr>
{{--   <div style="font-weight: bold">Grand total: <span id="grandTotal"></span></div>
    <div style="font-weight: bold">Grand tp: <span id="tp"></span></div>
 --}}
<div class="form-group form-group-lg {{ $errors->has('check') ? ' has-error' : ''}}">
  <label for="total" class="col-sm-4 control-label">Check Total</label>
  <div class="col-sm-5">
  <div class="input-group">
    <div class="input-group-addon">$</div>

    <input type="text" class="form-control input-lg" id="totalPrice" name="check" disabled value="">
  </div>
</div>
</div>

<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
  <label for="date" class="col-sm-4 control-label">Date</label>
  {{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
  <div class="col-sm-5">
    <input type="text" class="form-control" id="date" name="date" placeholder="{{ date('m/d/y') }}" value="{{ old('date', date('m/d/Y')) }}">
  </div>
</div>
{{-- 
<div class="form-group form-group-lg {{ $errors->has('check') ? ' has-error' : ''}}">
  <label for="total" class="col-sm-4 control-label">Check Total</label>
  <div class="col-sm-5">
  <div class="input-group">
    <div class="input-group-addon">$</div>

    <input type="text" class="form-control input-lg" id="totalll" name="check" disabled value="">
  </div>
</div>
</div> --}}

<div class="form-group {{ $errors->has('check_id') ? ' has-error' : ''}}">
  <label for="check_id" class="col-sm-4 control-label">Check</label>
  <div class="col-sm-5">
    <input type="number" class="form-control" id="check_id" placeholder="1020" name="check_id" value="{{ old('check_id') }}">
  </div>
</div>

<div class="form-group {{ $errors->has('paid_by') ? ' has-error' : ''}}">
  <label for="paid_by" class="col-sm-4 control-label">Paid By</label>
  <div class="col-sm-5">
    <select class="form-control" id="paid_by" name="paid_by">
      {{-- Can we put old('paid_by') elsewhere? to clean up this view? --}}
      <option value="0" 
        {{ old('paid_by', isset($expense) ? $expense->paid_by : '') == "0" ? "selected" : "" }}>
        {{ App\Vendor::findOrFail(Auth::user()->primary_vendor)->getName() }}
      </option>
      @foreach ($employees as $employee)
      <option value="{{$employee->id}}" 
        {{ old('paid_by', isset($expense) ? $expense->paid_by : '') == $employee->id ? "selected" : "" }}>
        {{ $employee->first_name }}
      </option>
      @endforeach
    </select>
  </div>
</div>

<div class="form-group {{ $errors->has('invoice') ? ' has-error' : ''}}">
  <label for="invoice" class="col-sm-4 control-label">Reference</label>
  <div class="col-sm-5">
    <input type="text" class="form-control" id="invoice" placeholder="2010" name="invoice" value="{{ old('invoice', isset($expense) ? $expense->invoice : '') }}">
  </div>
</div>

<div class="form-group">
  <label for="note" class="col-sm-4 control-label">Notes</label>
  <div class="col-sm-5">
    <textarea class="form-control" rows="3" id="note" name="note">{{ old('note') }}</textarea>
  </div>
</div>

<div class="form-group">
  <div class="col-sm-4"></div>
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Add Payment</button>
  </div>
</div>

<script type="text/javascript">

$(document).on("keyup", ".vendor_accounts input", function() {
  $(this).trigger("recalc");
});

$(document).on("recalc", ".vendor_accounts .counts", function() {
  var total = +$(this).find(".bid").val() - +$(this).find(".payment").val() - +$(this).find(".current_balance").val();
  $(this).find(".balance").val(total.toFixed(2));
});

$(document).on("recalc", ".vendor_accounts", function () {
  var inputTotal = 0;
  $(this).find(".payment").each(function () {
    inputTotal += +$(this).val();
  });
  $("#inputTotal").val(inputTotal.toFixed(2));
  updateGrandTotalDisplayed();
/*  $("#totalPrice").val(inputTotal.toFixed(2));*/

});


$(".vendor_accounts").trigger("recalc");


$(document).ready(function() {
  var checkTotal = 0;
  $('.box:checked').each(function(){
      checkTotal+= +($(this).attr("rel"));
  });
  $('#checkTotal').val(checkTotal.toFixed(2));
  updateGrandTotalDisplayed();
});

$(document).ready(function() {
  $('.box').change(function(){
    var checkTotal = 0;
    $('.box:checked').each(function(){
        checkTotal+= +($(this).attr("rel"));
    });
    $('#checkTotal').val(checkTotal.toFixed(2));
    updateGrandTotalDisplayed();
  });
});

/*$("#checkTotal").change(function(){
  alert("The text has been changed.");
});
*/

function updateGrandTotalDisplayed(val){
  var input1 = parseFloat($('#checkTotal').val());
  var input2 = parseFloat($('#inputTotal').val());
  var total = input1 + input2;
  $('#totalPrice').val(total.toFixed(2));
};

/*$(document).ready(function() {
    var totalPrice = +val(checkTotal) + val(inputTotal);
    
    $('#totalPrice').val(totalPrice.toFixed(2));
});
*/

</script>