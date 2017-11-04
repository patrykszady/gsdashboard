@extends('main')

@section('title', $distribution->name)

@section('content')
<h1>{{$distribution->name}} Balance {{ $distribution->getBalance()}}</h1>
{{-- <div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Project <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-default">Edit Project</a></h3>
		  	</div>
			<div class="panel-body">
				<h3>@yield('title')</h3>
				<hr>
				<div class="col-xs-6">
				<p>
					<strong>Jobsite Address:</strong>
					<br>
					{{$project->getFulladdress1()}}
					<br>
					{{$project->getFulladdress2()}}
				</p>
				</div>
				<div class="col-xs-6">
				<p>
					<strong>Billing Address:</strong>
					<br>
					{{$project->client->getFulladdress1()}}
					<br>
					{{$project->getFulladdress2()}}
				</p>

				</div>
			
				<div class="col-md-12">
					@include('projects._statusform')
				</div>

			</div>

		</div>

	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Details</h3>
		  	</div>
			<div class="panel-body">
				
			
			
			<div class="col-md-6">
				<ul class="list-group">
					<li class="list-group-item">${{ $expenses->sum('amount') }} | Expenses</li>
					<li class="list-group-item">${{ $project->hours->sum('amount') }} | {{ $project->hours->sum('hours') }} Hours | Timesheets </li>
					<li class="list-group-item">{{$project->getTotalCost()}} | Total Cost</li>
					<hr>
					<li class="list-group-item">{{ $project->getProfit() }} | Profit</li>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="list-group">
					<li class="list-group-item">${{ $project->project_total }} | Project Estimate</li>
					<li class="list-group-item">${{ $project->change_order }} | Change Order</li>
					<li class="list-group-item">${{ $project->expenses->where('reimbursment', 'Client')->sum('amount') }} | Reimbursment</li>
					<li class="list-group-item">{{ $project->getProjectTotal() }} | Project Total</li>
				</ul>
			</div>
			</div>
		
		</div>
	</div>
</div> --}}

<table class="table table-striped table-hover">
<thead>
	<th>Project Name</th>
	
		<th>{{ $distribution->name }}</th>
	
</thead>

<tbody>
		
@foreach ($projects as $project)

<tr>
	<td>{{$project->getProjectname()}}</td>
	
	@foreach($project->distributions->where('id', $distribution->id) as $distribution)
	<td>{{$project->getDistBalance($distribution)}} | {{$distribution->pivot->percent}} %</td>
	@endforeach
	
</tr>

@endforeach

</tbody>
</table>

@include('expenses._table')


@endsection

