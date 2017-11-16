@extends('main')

@section('title', 'Check ' . $check->check)

@section('content')

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Check {{$check->check}} <a href="{{ route('checks.edit', $check->check) }}" class="btn btn-default">Edit Check</a>
		    	</h3>
		  	</div>
			<table class="table table-hover">
				<tbody>
					<tr>
						<td width="40%"><strong>Payee</strong></td>
						<td><a href="{{ $check->getPayeeRoute() }}"> {{ $check->getName()}}</a></td>
					</tr>
					<tr>
						<td><strong>Amount</strong></td>
						<td>{{ money($check->getTotal()) }}</td>
					</tr>
					<tr>
						<td><strong>Check Number</strong></td>
						<td>{{ $check->check }}</td>
					</tr>
					<tr>
						<td><strong>Date</strong></td>
						<td>{{ $check->date->toFormattedDateString() }}</td>
					</tr>
					<tr>
						<td><strong>Entered By</strong></td>
						<td><a href="{{ route('users.show', $check->created_by_user_id) }}">{{ $check->getCreatedBy() }}</a> on {{$check->updated_at->toFormattedDateString() }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		@include('expenses._table', $expenses = $check->expenses)
	</div>
</div>

@if($check->hours->count() > 1)
<div class="row"> 
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Individual Timesheets <a href="{{ url('hours/create') }}" class="btn btn-default">New Timesheet</a></div>
		
			<table class="table table-striped table-hover">
				<thead>
					<th>Hours</th>
					<th>Project</th>
					<th>Date</th>
				</thead>
				<tbody>
					@foreach ($check->hours as $hour)
						<tr>		
							<td>
			   					{{ $hour->hours }}
							</td>
							<td>
			   					{{ $hour->project->getProjectname() }}
							</td>
							<td>
			   					{{ $hour->date->toFormattedDateString() }}
							</td>
						</tr>

					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endif
@endsection

