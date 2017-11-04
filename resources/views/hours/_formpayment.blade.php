<div class="panel panel-default">
<!-- Default panel contents -->
	<div class="panel-heading">Unpaid Timesheets</div>
	@foreach ($timesheets as $hour)
	
		<ul class="list-group">
			<li class="list-group-item disabled"><strong>${{ $hour->where('check_id', NULL)->sumOfHours($hour->user_id, $hour->date)}} </strong> |  {{ $hour->where('check_id', NULL)->sumHours($hour->user_id, $hour->date) }} hours on <strong> {{ $hour->getDate() }} </strong>	
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

<div class="panel panel-default">
<!-- Default panel contents -->
	<div class="panel-heading">Expenses Paid For</div>

<!-- List group -->
@foreach ($expenses as $expense)

	<ul class="list-group">
		<li class="list-group-item">
		<input class="box" type="checkbox" checked value="{{$expense->id}}" name="expense[]" rel="{{$expense->amount}}">&nbsp;&nbsp;&nbsp;&nbsp;
		<strong>{{  $expense->getAmount()}} </strong> 
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
<div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
	<label for="date" class="col-sm-4 control-label">Date</label>
	{{-- JS to auto select this text on pageload (autofocus="autofocus" onfocus="this.select()")--}}
	<div class="col-sm-6">
		<input type="text" class="form-control" id="date" name="date" placeholder="{{ date('m/d/y') }}" value="{{ old('date', date('m/d/Y')) }}">
	</div>
</div>


<div class="form-group {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="check" class="col-sm-4 control-label">Check</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" id="check" name="check" placeholder="607" value="{{ old('check') }}" autofocus="autofocus">
	</div>
</div>

<div class="form-group form-group-lg {{ $errors->has('check') ? ' has-error' : ''}}">
	<label for="total" class="col-sm-4 control-label">Check Total</label>
	<div class="col-sm-6">
	<div class="input-group">
		<div class="input-group-addon">$</div>

		<input type="text" class="form-control input-lg" id="total" name="check" disabled value="">
	</div>
</div>
</div>

<div class="form-group">
	<div class="col-sm-4"></div>
	<div class="col-sm-6">
		<button type="submit" class="btn btn-success btn-block">Pay</button>
	</div>
</div>