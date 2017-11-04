<table class="table table-striped table-hover">
<thead>
	<th>Date</th>
	<th>Hours</th>	
	<th>Employee</th>
	<th>Actions</th>
</thead>

<tbody>

@foreach ($hourss as $hour)
<tr>
	{{--  if Year is current, dont show, if it's past or future show--}}
	@if (date('Y', strtotime($hour->date)) == date('Y'))
		<td>{{ $hour->date->format('M j') }}</td>
	@else
		<td>{{ $hour->date->format('m/d/y') }}</td>
	@endif
	<td><strong>{{ $hour->where('check', '!=', null)->sumHours($hour->user_id, $hour->date) }}</strong> </td>
	<td><a href="{{ route('users.show', $hour->user->id)}}">{{ $hour->user->first_name }}</a></td>
{{-- 	<td>
		<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-default">View</a>
		<a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default">Edit</a>

	</td> --}}
</tr>

@endforeach

</tbody>
</table>