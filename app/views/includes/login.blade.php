<div class="row-fluid" >
	<div class="item bg">
		<img src="_/fonts/bg_img.png" >
		<div class="well" style="padding-top:100px;">
			<div class="caption-bg">
				<div class="container-fluid">
				<div class="col-md-6 col-md-offset-3">
				<div class="well well-bg">
					@if (Session::has('flash_message'))
							<div class="form-group ">
								<p>{{Session::get('flash_message') }}</p>
							</div>
					@endif
					<center><h3>Login to your account</h3></center>
					{{ Form::open(['route'=>'sessions.store']) }}
					<hr class="style-fade">
					<div class="container-fluid">
					<div class="col-md-6 col-md-offset-3">
						<div class="form-group">
							{{Form::text('username',null,['class'=>'form-control square','placeholder'=>'Username'])}}
							{{ errors_for('username', $errors)}}
						</div>
						<div class="form-group">
							{{Form::password('password',['class'=>'form-control square','placeholder'=>'Password'])}}
							{{ errors_for('password', $errors)}}
						</div>
						<div class="form-group">
							{{ Form::Submit('Sign in',['class'=>'btn btn-success square','style'=>'width:100%;']) }}
						</div>
					</div>
					</div>
					{{ Form::close()}}	
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>