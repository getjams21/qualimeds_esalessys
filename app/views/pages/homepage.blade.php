@extends('layouts.master')
@section('meta-title','Home')
@section('metatags')

@stop
<!-- navbar -->
@section('header')
	@include('includes.navbar')
@stop
@section('content')
	@include('includes.login')
@stop
<!-- footer -->
@section('footer')
	
@stop