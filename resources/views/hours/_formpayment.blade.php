@if(count($timesheets) > 0)
<div class="panel panel-default">
	<div class="panel-heading">Unpaid Timesheets</div>
	@foreach ($timesheets as $hour)
	
		<ul class="list-group">
			<li class="list-group-item disabled"><strong>${{ $hour->where('check_id', NULL)->where('invoice', NULL)->sumOfHours($hour->user_id, $hour->date)}} </strong> |  {{ $hour->where('check_id', NULL)->sumHours($hour->user_id, $hour->date) }} hours on <strong> {{ $hour->getDate() }} </strong>	
			</li>
		</ul>
		@foreach($hours->where('date', $hour->date) as $hour)
		<ul class="list-group">
			<li class="list-group-item">
				<input class="box" type="checkbox" name="hour[]" checked value="{{$hour->id}}" rel="{{ $hour->where('check_id', NULL)->where('id', $hour->id)->sumOfHours($hour->user_id, $hour->date)}}">
				&nbsp;&nbsp;&nbsp;&nbsp;${{ $hour->where('check_id', NULL)->where('id', $hour->id)->sumOfHours($hour->user_id, $hour->date)}} | 
				 <strong>{{  $hour->hours }} </strong>  hours on  {{ $hour->project->getProjectname()}}
			</li>
		</ul>
		@endforeach
	@endforeach
</div>
@endif

@if(count($expenses) > 0)
<div class="panel panel-default">
	<div class="panel-heading">Expenses Paid For</div>
	@foreach ($expenses as $expense)
		<ul class="list-group">
			<li class="list-group-item">
			<input class="box" type="checkbox" checked value="{{$expense->id}}" name="expense[]" rel="{{$expense->amount}}">&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>{{  money($expense->amount)}} </strong> 
			{{'paid for ' . $expense->vendor->business_name . ' on ' . $expense->getDate() . ' for project ' }}
			@if (isset($expense->project_id))
				@if ($expense->project_id == 0)
				<a href="{{ route('expenses.show', $expense->id)}}">Expense Split</a>
				@else
				<a href="{{ route('projects.show', $expense->project->id)}}">{{ $expense->project->getProjectname() }}</a>
				@endif
			@else
				<a href="{{ route('distributions.show', $expense->distribution->id) }}">{{$expense->distribution->name}}</a>
			@endif
			</li>
		</ul>
	@endforeach
</div>
@endif

@if(count($paid_by_hours) > 0)
<div class="panel panel-default">
	<div class="panel-heading">Timesheets Paid For</div>
	@foreach ($paid_by_hours as $paid_by_hour)
		<ul class="list-group">
			<li class="list-group-item">
			<input class="box" type="checkbox" checked value="{{$paid_by_hour->id}}" name="paid_by_hour[]" rel="{{$paid_by_hour->where('check_id', NULL)->where('invoice', '!=', NULL)->where('id', $paid_by_hour->id)->sumOfHours($paid_by_hour->user_id, $paid_by_hour->date)}}">

			&nbsp;&nbsp;&nbsp;&nbsp;${{ $paid_by_hour->where('check_id', NULL)->where('invoice', '!=', NULL)->where('id', $paid_by_hour->id)->sumOfHours($paid_by_hour->user_id, $paid_by_hour->date)}} | 
			{{$paid_by_hour->user->first_name}} <strong>{{  $paid_by_hour->hours }} </strong>  hours on  {{ $paid_by_hour->project->getProjectname()}}

			</li>
		</ul>
	@endforeach
</div>
@endif

<hr>
<div class="form-group form-group-lg {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="total" class="col-sm-4 control-label">Check Total</label>
	<div class="col-sm-6">
		<div class="input-group">
			<div class="input-group-addon">$</div>

			<input type="text" class="form-control input-lg" id="total" name="check" disabled value="">
		</div>
	</div>
</div>
<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="date" name="date" placeholder="{{ date('m/d/y') }}" value="{{ old('date', date('m/d/Y')) }}">
	</div>
</div>

<div class="form-group {{ $errors->has('paid_by') ? ' has-error' : ''}}">
  <label for="paid_by" class="col-sm-4 control-label">Paid By</label>
  <div class="col-sm-6">
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



<div id="row_check">
<div class="form-group {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="check" class="col-sm-4 control-label">Check</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="check" name="check" placeholder="607" value="{{ old('check') }}" autofocus="autofocus">
	</div>
</div>
</div>

<div id="row_reference">
<div class="form-group {{ $errors->has('invoice') ? ' has-error' : ''}}">
	<label for="invoice" class="col-sm-4 control-label">Reference</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="invoice" placeholder="2010" name="invoice" value="{{ old('invoice') }}">
	</div>
</div>
</div>



<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Pay</button>
	</div>
</div>