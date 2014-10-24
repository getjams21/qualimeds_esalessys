@extends('layouts.master')
@section('content')
	{{ $message }}
	<br>
	<h4>{{link_to('tasks','Go Home')}}</h4>
@stop