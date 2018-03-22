<div class="form-group {{ $errors->has("amount.$i")  ? ' has-error' : '' }}">
	<label for="amount" class="col-sm-4 control-label">Amount</label>
	<div class="col-sm-8">
		<div class="input-group">
		    <div class="input-group-addon">$</div>
			    <input type="text" class="form-control txt" id="$amount.$i" name="amount[]" value="{{ old("amount.$i", isset($expense_split) ? $expense_split->amount : '')}}">
		</div>
	</div>
</div>

<div class="form-group {{ $errors->has("project_id.$i")  ? ' has-error' : '' }}">
	<label for="project_id" class="col-sm-4 control-label">Project</label>
	<div class="col-sm-8">
		<select class="form-control" id="project_id.$i" name="project_id[]">
				<option value=""
					{{ old("project_id.$i", isset($expense_split) ? $expense_split->project_id : '') == "" ? "selected" : "" }}>
					None
				</option>

			@foreach ($projects as $project)

				<option value="{{$project->id}}" 
					{{ old("project_id.$i", isset($expense_split->project_id) ? $expense_split->project_id : '') == $project->id ? "selected" : "" }}>
					{{ $project->getProjectname() }}
				</option>
			@endforeach

			<option disabled>ACCOUNTS</option>

			@foreach ($distributions as $distribution)
				<option value="A:{{$distribution->id}}" 
					{{ old("project_id.$i", isset($expense_split) ? 'A:' . $expense_split->distribution_id : '') == 'A:' . $distribution->id ? "selected" : ""}}>
					{{ $distribution->name }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label for="reimbursment" class="col-sm-4 control-label">Reimbursment</label>
	<div class="col-sm-8">
		<select class="form-control" id="reimbursment.$i" name="reimbursment[]">
			<option value="" {{ old("reimbursment.$i", isset($expense_split) ? $expense_split->reimbursment : '') == "" ? "selected" : "" }}>None</option>
			<option value="Client" {{ old("reimbursment.$i", isset($expense_split) ? $expense_split->reimbursment : '') == "Client" ? "selected" : "" }}>Client</option>
			<option value="Contractors" disabled>Contractors</option>
			@foreach ($vendors as $vendor)
				<option value="{{$vendor->id}}" 
					{{ old("reimbursment.$i", isset($expense_split) ? $expense_split->reimbursment : '') == $vendor->id ? "selected" : "" }}>
					{{ $vendor->getName() }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label for="note" class="col-sm-4 control-label">Notes</label>
	<div class="col-sm-8">
		<textarea class="form-control" rows="1" id="note.$i" name="note[]">{{ old("note.$i", isset($expense_split) ? $expense_split->note : '') }}</textarea>
	</div>
</div>
