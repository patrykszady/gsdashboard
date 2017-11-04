@extends('main')

	@section('title', 'Check ' . $check->check)

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Check</h3>
		  	</div>
			<div class="panel-body">
				<h3>Check {{$check->check}} for {{$check->getName()}} for {{ $check->getTotal($vendor = isset($vendor) ? $vendor : null) }}</h3>
				<hr>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
			@include('expenses._table', $expenses = $check->expenses)
	</div>
</div>
<div class="row">
	<div class="col-md-8">
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

@endsection

