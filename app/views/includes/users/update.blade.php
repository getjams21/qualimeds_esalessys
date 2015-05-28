@if (Session::has('flash_message'))
	<p>{{Session::get('flash_message') }}</p>
@endif
<div class="panel panel-success">
	<div class="panel-heading head">
		<h4>Update Account</h4>
	</div>
	<div class="panel-body">	
		<div class="container-fluid">
        	<div class="col-md-8 col-md-offset-2">
			<div class="well customerForm">
			<div>
			{{ Form::open(['url' => '/user/'.Auth::user()->id.'/updateuser']) }}
			<div class="form-group">
				<label>Username</label>
				<input class="form-control username" type="text" name="username" id="username" placeholder="Username" value="{{Auth::user()->username}}" required>
			</div>
			<div class="form-group">
				<label>Current Password</label>
				<input type="password" class="form-control password" name="current-password" id="current-password" placeholder="Current password" required></textarea>
				<input type="hidden" name="isCurrentPW" id="isCurrentPW" value="">
				<div class="alert alert-danger" role="alert" hidden>
					Wrong Password!
				</div>
			</div>
			<div class="form-group">
				<label>New Password</label>
				<input type="password" class="form-control password" name="password" id="password" placeholder="Password" required></textarea>
			</div>
			<div class="form-group">
				<label>Retype Password</label>
				<input type="password" class="form-control retype-password" name="password_confirmation" placeholder="Retype Password" required></textarea>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input class="form-control lastname" type="text" name="Lastname" id="lastname" placeholder="Last Name" value="{{Auth::user()->Lastname}}" required>
			</div>
			<div class="form-group">
				<label>First Name</label>
				<input class="form-control firstname" type="text" name="Firstname" id="firstname" placeholder="First Name" value="{{Auth::user()->Firstname}}" required>
			</div>
			<div class="form-group">
				<label>Middle Initial</label>
				<input class="form-control mi" type="text" name="MI" id="mi" maxlength="1" style="width:38px;" value="{{Auth::user()->MI}}" required>
				<input type="hidden" name="id" id="library-action" value="{{Auth::user()->id}}">
				<input type="hidden" name="UserType" value="{{Auth::user()->UserType}}">
			</div>
			</div>
			</div>
			<center><button class="btn btn-success" type="submit">Update</button></center>
			</div>
			 {{ Form::close() }}
		</div>
	</div>
</div>