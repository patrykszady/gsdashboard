@extends('main')

@section('title', 'Projects')

@section('content')

<div class="row">

	<div class="col-md-10">
		<h1>All Projects</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('projects.create') }}" class="btn btn-lg btn-block btn-primary">New Project</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">
		@include('projects._table')		
	</div>
	
</div>

@endsection