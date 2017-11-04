<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<input name="vendor_id" type="hidden" value="{{ $vendor->id }}">

<div class="bank_table">
@foreach ($projects as $key => $project)

<h4>{{$project->getProjectname()}}</h4>

<div class="form-group">

	<div class="col-sm-4">
	<div class="input-group {{ $errors->has("bid.$key") ? ' has-error' : '' }}">
	<div class="input-group-addon">$</div>
		<input type="text" class="form-control balance bid" id="bid.$key" placeholder="1200" name="bid[]" value="{{ old("bid.$key", $project->bids->where('vendor_id', $vendor->id)->sum('amount')) }}">
		
	</div>
	<p class="help-block">Bid</p>
	</div>

	<div class="col-sm-5">
	<div class="input-group {{ $errors->has("amount.$key") ? ' has-error' : '' }}">
	<div class="input-group-addon">$</div>
		<input type="text" class="form-control payment" id="$amount.$key" placeholder="{{$project->bids->where('vendor_id', $vendor->id)->sum('amount') - $project->expenses->where('vendor_id', $vendor->id)->sum('amount') }}" name="amount[]" value="{{ old("amount.$key", '') }}">
		
	</div>
	<p class="help-block">Payment</p>
	</div>

	<div class="col-sm-3">
	<div class="input-group">
	<div class="input-group-addon">$</div>
		<input type="text" class="form-control balance" id="balance.$key" name="balance[]">
	</div>
	<p class="help-block">Balance</p>
	</div>

	<input name="project_id[]" id="project_id.$key" type="hidden" value="{{ old("project_id.$key", $project->id) }}">
	
</div>
<hr>
@endforeach

<div style="font-weight: bold">Grand total: <span id="grandTotal"></span></div>
</div>
<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-5">
		<input type="text" class="form-control" id="date" name="date" placeholder="{{ date('m/d/y') }}" value="{{ old('date', date('m/d/Y')) }}" autofocus="autofocus" onfocus="this.select()">
	</div>
</div>

<div class="form-group form-group-lg {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="total" class="col-sm-4 control-label">Check Total</label>
	<div class="col-sm-5">
	<div class="input-group">
		<div class="input-group-addon">$</div>

		<input type="text" class="form-control input-lg" id="totalPrice" name="check" disabled value="">
	</div>
</div>
</div>

<div class="form-group {{ $errors->has('check_id') ? ' has-error' : ''}}">
	<label for="check_id" class="col-sm-4 control-label">Check</label>
	<div class="col-sm-5">
		<input type="number" class="form-control" id="check_id" placeholder="1020" name="check_id" value="{{ old('check_id') }}">
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

$(document).on("keyup", ".bank_table input", function() {
  $(this).trigger("recalc");
});

$(document).on("recalc", ".thisthis", function() {
  var total = +$(this).find(".bid").val() * +$(this).find(".payment").val();
  $(this).find(".balance").val(total.toFixed(2));
});

$(document).on("recalc", ".bank_table", function () {
  var grandTotal = 0;
  $(this).find(".balance").each(function () {
    grandTotal += +$(this).val();
  });
  $("#grandTotal").text(grandTotal.toFixed(2));
});

$(".bank_table").trigger("recalc");



</script>

