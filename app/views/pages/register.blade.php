@extends('layouts.master')
@section('content')
	<div class="well container-top-margin">
		<center>
			<h1 class="breadcrumb breadcrumb-color-reg">Register a New Account</h1>
		</center>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			{{ Form::open(['url'=>'pages/store','role'=>'form']) }}
				<div class="form-group">
					<label for="inputUsername"><h4>Username:</h4></label>
					{{ Form::text('Username', '', array('class' => 'span3 form-control', 'id' => 'inputUsername', 'placeholder' => 'Username')) }}
				</div>
				<div class="form-group">
					<label for="inputEmail"><h4>Email:</h4></label>
					{{ Form::text('Email', '', array('class' => 'span3 form-control', 'id' => 'inputEmail', 'placeholder' => 'Email')) }}
				</div>
				<div class="form-group">
					<label for="inputPassword"><h4>Password:</h4></label>
					{{ Form::password('Password',array('class'=>'span3 form-control', 'id'=>'password', 'placeholder'=>'Password')) }}
				</div>
				<div class="form-group">
					<label for="verifyPassword"><h4>Verify Password:</h4></label>
					{{ Form::password('Password',array('class'=>'span3 form-control', 'id'=>'verify-password', 'placeholder'=>'Verify Password')) }}
				</div>
				<div class="form-group">
					<div class="alert alert-danger hide" id="alert-verify-password-remove">
						Password don't match!
						<div class="glyphicon glyphicon-remove alert-icon-padding-remove"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="alert alert-success hide" id="alert-verify-password-ok">
						Password matched!
						<div class="glyphicon glyphicon-ok alert-icon-padding-ok"></div>
					</div>
				</div>
				<div class="form-group">
					{{ Form::submit('Register',array('class'=>'btn btn-success')) }}
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop