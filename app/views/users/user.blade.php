@extends('layouts.default')

@section('content')
	<h1>User List</h1>
	@foreach ($user as $user)
	<li>{{ link_to ("/users/{$user->Name}", $user->Name) }}</li>
	@endforeach
@stop
