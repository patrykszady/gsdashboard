<div class="col-md-8 col-md-offset-2">
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
					<div class="col-sm-4">
						<button type="submit" name="update" value="update" class="btn btn-success btn-block">Update</button>
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