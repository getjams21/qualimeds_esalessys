@extends('layouts.master')
@section('content')
	<div class="well container-top-margin">
		<h1>All Tasks</h1>
		<ul class="list-group">
			@foreach ($tasks as $task)
				<li class="list-group-item">{{ link_to("tasks/$task->id", $task->title) }}</li>
			@endforeach
		</ul>
		<a class="btn btn-primary" href="pages/register" role="button">Register</a>
	</div>
@stop
		
