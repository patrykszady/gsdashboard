<div class="col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">@yield('title')</h3>
	  	</div>
		<div class="panel-body">
			<form class="form-horizontal" action="/expenses/{{$expense->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PATCH') }}
				@include('expenses._form')


				<div class="form-group">
					<div class="col-sm-4"></div>
					<div class="col-sm-2">
						<button type="submit" name="update" value="update" class="btn btn-success btn-block">Update</button>
					</div>
					<div class="col-sm-2">
						<button type="submit" name="split" value="split" class="btn btn-warning btn-block">Edit Splits</button>
					</div>
					<div class="col-sm-2">
						<a href="{{ route('expenses.destroy', $expense->id) }}" class="btn btn-danger btn-block"
			                onclick="event.preventDefault();
			                         document.getElementById('destroy-form').submit();">
			                Delete
            			</a>
					</div>
				</div>

			</form>

			<form id="destroy-form" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
		</div>
	</div>
</div>
<div class="col-md-4" style="position: sticky; top: 10px;">

@foreach($expense_splits as $expense_split)
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Split</h3>
	  	</div>
		<table class="table table-hover">
			<tbody>
				<tr>
					<td width="35%"><strong>Amount</strong></td>
					<td>${{ $expense_split->amount }}</td>
				</tr>
				<tr>
					@if (isset($expense_split->project_id))
					<td><strong>Project</strong></td>
					<td><a href="{{ route('projects.show', $expense_split->project->id)}}">{{ $expense_split->project->getProjectname() }}</a></td>
					@else
					<td><strong>Account</strong></td>
					<td><a href="{{ route('distributions.show', $expense_split->distribution->id) }}">{{$expense_split->distribution->name}}</a></td>
					@endif
				</tr>
				<tr>
					<td><strong>Reimbursment</strong></td>
					<td>{{ $expense_split->getReimbursment() }}</td>
				</tr>
				<tr>
					<td><strong>Reference</strong></td>
					<td>{{ $expense_split->expense->invoice }}</td>
				</tr>
				<tr>
					<td><strong>Check</strong></td>
					<td><a href="{{ route('checks.show', $expense_split->expense->check_id)}}">{{ $expense_split->expense->check_id }}</a></td>
				</tr>
				<tr>
					<td><strong>Created By</strong></td>
					<td><a href="{{ route('users.show', $expense_split->created_by_user_id)}}">{{ $expense_split->getCreatedBy() }}</a></td>
				</tr>
				<tr>
					<td><strong>Notes</strong></td>
					<td>{{ $expense_split->note }}</td>
				</tr>
			</tbody>
		</table>
	</div>
@endforeach
</div>