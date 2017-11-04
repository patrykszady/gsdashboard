<form class="form-inline" action="{{ route('projectstatuses.store') }}" method="POST">
{{ csrf_field() }}
<hr>
<div class="form-group">
	<label for="title_id" class="control-label">Project Status</label>
	<select class="form-control" id="title_id" name="title_id">
		<option value="0" {{ old('title_id', $project->latestStatus()->first()->title_id) == "0" ? "selected" : "" }}>Consultation</option>
		<option value="1" {{ old('title_id', $project->latestStatus()->first()->title_id) == "1" ? "selected" : "" }}>Estiamte</option>
		<option value="2" {{ old('title_id', $project->latestStatus()->first()->title_id) == "2" ? "selected" : "" }}>Awaiting Response</option>
		<option value="3" {{ old('title_id', $project->latestStatus()->first()->title_id) == "3" ? "selected" : "" }}>Project Prep</option>
		<option value="4" {{ old('title_id', $project->latestStatus()->first()->title_id) == "4" ? "selected" : "" }}>Scheduled</option>
		<option value="5" {{ old('title_id', $project->latestStatus()->first()->title_id) == "5" ? "selected" : "" }}>Active</option>
		<option value="6" {{ old('title_id', $project->latestStatus()->first()->title_id) == "6" ? "selected" : "" }}>Complete</option>
		<option value="7" {{ old('title_id', $project->latestStatus()->first()->title_id) == "7" ? "selected" : "" }}>Canceled</option>
	</select>
</div>
	<input type="hidden" name="project_id" value="{{$project->id}}">
	<div class="form-group">
		<button type="submit" class="btn btn-success">Change</button>
	</div>
</form>