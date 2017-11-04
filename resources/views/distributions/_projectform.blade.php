<div class="form-group form-group-lg {{ $errors->has('profit') ? ' has-error' : ''}}">
	<label for="total" class="col-sm-4 control-label">Project Profit</label>
	<div class="col-sm-6">
	<div class="input-group">
		<div class="input-group-addon">$</div>

		<input type="text" class="form-control input-lg" name="profit" disabled value="{{$project->getProfit()}}">
	</div>
</div>
</div>
<hr>

@foreach ($accounts as $key => $account)
<div class="form-group {{$errors->has("account.$key") ? ' has-error' : ''}}">
		<label for="account" class="col-sm-4 control-label">{{$account->name}}</label>
		<div class="col-sm-3">
		<div class="input-group">
		<div class="input-group-addon">%</div>

		<input type="text" class="form-control" id="account{{$key}}" name="account[]" placeholder="Owner - Home" value="{{ old("account.$key") }}" autofocus="autofocus" onfocus="this.select()">

	</div>
			
		</div>
		<div class="col-sm-3">
		<div class="input-group">
		<div class="input-group-addon">$</div>
		<input type="text" class="form-control" id="output-value{{$key}}" name="portion[]" disabled value="{{
			is_numeric(old("account.$key")) ? number_format(old("account.$key")* .01 * $project->getProfit(),2, '.', ',') : '0' }}">


	</div>
		
		</div>

	<input name="distribution_id[]" id="distribution_id.$key" type="hidden" value="{{ $account->id }}">
	
</div>

@endforeach

<input name="project_id" id="project_id" type="hidden" value="{{ $project->id }}">
<hr>