@extends('layouts.master')
@section('meta-title','Home')
@section('metatags')
@stop
<!-- navbar -->
@section('header')
	@include('dashboard.includes.navbar')
@stop
@section('content')
<div clas="row" >
<div id="wrapper">
@include('dashboard.includes.sidebar')
     <!-- Page Content -->
<div id="page-content-wrapper">
	<div class="container-fluid">
	    <div class="row">
	       	<div class="col-md-12 shadowed">
	                   <!-- default -->
	        </div>
	    </div>
	</div><!-- /#container-fluid -->
</div><!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
</div>  <!-- /#row -->
@stop
<!-- footer -->
@section('footer')
	
@stop