@extends('layouts.master')
@section('content')
	
	<h1> {{$task->body}} </h1>
	{{link_to('tasks','Go Back')}}
@stop