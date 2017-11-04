@extends('main')

@section('title', 'Timesheet for ' . $hour->date->toFormattedDateString())

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Timesheet</h3>
		  	</div>
			<div class="panel-body">
				<h3>{{ $hour->user->first_name . "'s"  }} @yield('title')</h3>
				<hr>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Projects <a href="{{ url('hours/create') }}" class="btn btn-default">New Timesheet</a></div>
		
{{-- 		<div class="panel-body">
		<p>...</p>
		</div> --}}

		<!-- Table -->
		
				<table class="table table-striped table-hover">
					<thead>
						<th>Project</th>
						<th>Hours</th>
						<th>Check</th>
						<th>Amount</th>
					</thead>

					<tbody>
						
						@foreach ($hours as $hour)

							<tr>
								<td><a href="{{ route('projects.show', $hour->project->id)}}">{{ $hour->project->getProjectname() }}</a>
								</td>				
								<td>
				   					{{ $hour->hours }}
								</td>
								<td>
				   					{{ $hour->check }}
								</td>
								<td>
				   					${{ $hour->hours * $hour->hourly }}
								</td>

								{{-- <td>${{ $project->expenses()->where('vendor_id', $expense->vendor_id)->sum('amount') }}</td> --}}
								{{-- <td>
									<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
									<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
								</td> --}}
							</tr>

						@endforeach

					</tbody>
				</table>
		</div>
	</div>

@if(isset($checks[0]))		
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Payments</div>		
				<table class="table table-striped table-hover">
					<thead>
						<th>Check</th>
						
					</thead>

					<tbody>
						
						@foreach ($checks as $check)

							<tr>
								{{-- <td><a href="{{ route('projects.show', $hour->project->id)}}">{{ $hour->project->getProjectname() }}</a>
								</td>		 --}}		
								<td>
								<a href="{{ route('expenses.check', $check->check)}}">{{ $check->check }}</a>
				   					
								</td>
								{{-- <td>
				   					{{ $hour->check }}
								</td>
								<td>
				   					${{ $hour->hours * $hour->hourly }}
								</td> --}}

								{{-- <td>${{ $project->expenses()->where('vendor_id', $expense->vendor_id)->sum('amount') }}</td> --}}
								{{-- <td>
									<a href="{{ route('projects.show', $project->id) }}" class="btn btn-default">View</a>
									<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit</a>
								</td> --}}
							</tr>

						@endforeach

					</tbody>
				</table>
		</div>
	</div>
@endif
</div>






{{-- 
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Expenses</div>
		<div class="panel-body">
		<p>...</p>
		</div>

		Table
		@include('expenses._table')
	</div>
	</div>
</div>
 --}}


@endsection

