@extends('main')

@section('title', 'Update Check')

@section('content')

<!-- Large modal -->
<div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
			<div class="modal-header">
			    <h4 class="modal-title" id="gridSystemModalLabel">Delete Check <strong> {{$check->check}} </strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
			    	<div class="col-md-10 col-md-offset-1">
						<h2>Are you sure?</h2>
						<p>Deleting this check will also completley delete any associated expenses, timesheet hours, and any assoicated information like Expense Splits and Receipt Images</p>
						<strong><h1>Clicking DELETE cannot be undone!</h1></strong>
					</div>
				</div>
			    <div class="row">
			    	<div class="col-md-10 col-md-offset-1">
					<a href="{{ route('checks.destroy', $check->id) }}" class="btn btn-danger btn-block"
				        onclick="event.preventDefault();
				                 document.getElementById('destroy-form').submit();">
				        <strong>DELETE</strong>
					</a>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">@yield('title')</h3>
		  	</div>
			<div class="panel-body">
				<form class="form-horizontal" action="/checks/{{$check->id}}" method="POST" autocomplete="off" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
					@include('checks._form')

					<div class="form-group">
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<button type="submit" name="update" value="update" class="btn btn-success btn-block">Update</button>
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target=".delete-modal">Delete</button>
						</div>
					</div>

				</form>

				<form id="destroy-form" action="{{ route('checks.destroy', $check->id) }}" method="POST" style="display: none;">
	                {{ csrf_field() }}
	                {{ method_field('DELETE') }}
	            </form>
			</div>
		</div>
	</div>
</div>

@endsection