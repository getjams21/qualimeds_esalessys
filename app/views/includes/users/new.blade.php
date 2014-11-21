<!-- User Add Modal -->
<div class="modal fade" id="user-library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Users</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        	<div class="col-md-12">
			<div class="well customerForm">
			<div>
			{{ Form::open(['route'=>'Users.store', 'id'=>'customerForm']) }}
			<div class="form-group">
				<label>Username</label>
				<input class="form-control username" type="text" name="username" id="username" placeholder="Username" required>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control password" name="password" id="password" placeholder="Password" required></textarea>
			</div>
			<div class="form-group">
				<label>Retype Password</label>
				<input type="password" class="form-control retype-password" name="password_confirmation" placeholder="Retype Password" required></textarea>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input class="form-control lastname" type="text" name="Lastname" id="lastname" placeholder="Last Name" required>
			</div>
			<div class="form-group">
				<label>First Name</label>
				<input class="form-control firstname" type="text" name="Firstname" id="firstname" placeholder="First Name">
			</div>
			<div class="form-group">
				<label>Middle Initial</label>
				<input class="form-control mi" type="text" name="MI" id="mi" maxlength="1" style="width:38px;" required>
			</div>
			<div class="form-group">
				<label>User Type</label>
				<select class="form-control" id="usertype" name="UserType">
				  <option class="" value="1" selected>Admin</option>
				  <option class="" value="11">Admin/Sales Rep</option>
				  <option class="" value="2">Warehouse User</option>
				  <option class="" value="3">Office Clerk</option>
				  <option class="" value="4">Sales Rep</option>
				</select>
				<input type="hidden" name="id" id="library-action" value="">
			</div>
			<div class="form-group">
				<label>Branch</label>
				{{Form::select('BranchNo', $branches, 'key', array('class' => 'form-control square','id'=>'branches'));}}
			</div>
			</div>
			</div>
			</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       	<button class="btn btn-success" type="submit">Submit</button>
       	<a class="deactivate" href=""><button class="btn btn-danger delete pull-left" type="button">Deactivate</button></a>
      </div>     	
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- Customer Edit/Deactivate Modal -->


@if (Session::has('flash_message'))
	<p>{{Session::get('flash_message') }}</p>
@endif
<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="container-fluid">
			<font size="5">Users</font>
			<button class="btn btn-success add-bank pull-right square" data-toggle="modal" data-target="#user-library">
		  	<span class="glyphicon glyphicon-plus"></span> New User
			</button>
		</div>
	</div>
	<div class="panel-body">	
		<div class="container-fluid">
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>MI</th>
                      <th>User Type</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Users as $User)
                    	<tr>
                          	<td>{{$User->username}}</td>
                          	<td>{{$User->Lastname}}</td>
                          	<td>{{$User->Firstname}}</td>
                          	<td>{{$User->MI}}</td>
                          	<td><?php 
	                          	if($User->UserType == 1){
	                          		echo 'Admin';
	                          	}elseif ($User->UserType == 11) {
	                          		echo 'Admin/Sales Rep';
	                          	}elseif ($User->UserType == 2) {
	                          		echo 'Warehouse User';
	                          	}elseif ($User->UserType == 3) {
	                          		echo 'Office Clerk';
	                          	}elseif ($User->UserType == 4) {
	                          		echo 'Sales Rep';
	                          	}
	                          	?></td>
                          	<td><center><button class="btn btn-success btn-sm" onclick="triggerEditUser({{$User->id}})"><span class="glyphicon glyphicon-cog"></span> Edit</button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>