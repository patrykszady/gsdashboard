<table class="table table-striped table-hover">
<thead>
	<th>Date</th>
	<th>Hours</th>	
	<th>Employee</th>
	<th>Actions</th>
</thead>

<tbody>

@foreach ($hours as $hour)
<tr>
	{{--  if Year is current, dont show, if it's past or future show--}}
	
	<td>{{ $hour->getDate() }}</td>
	
	<td><strong>{{ $hour->sumHours($hour->user_id, $hour->date) }}</strong> | ${{ $hour->sumOfHours($hour->user_id, $hour->date)}}</td>
	<td><a href="{{ route('users.show', $hour->user->id)}}">{{ $hour->user->first_name }}</a></td>
	<td>
		<a href="{{ url('hours/payment', $hour->user_id) }}" class="btn btn-default">Pay</a>
		{{-- <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default">Edit</a>
 --}}
	</td>
</tr>

@endforeach

</tbody>
</table>