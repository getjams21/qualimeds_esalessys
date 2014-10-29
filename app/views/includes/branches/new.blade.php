<div class="panel panel-success">
	<div class="panel-heading head">
		<h4>Branches</h4>
	</div>
	<div class="panel-body">
		<center><h4>New Branch</h4></center>
		<hr class="style-fade">	
		<div class="container-fluid">
			<div class="col-md-8 col-md-offset-2">
			<div class="well branchForm">
			<div>
			{{ Form::open(['route'=>'branches.store']) }}
			<div class="form-group">
				<input class="form-control name" type="text" name="name" placeholder="Branch Name" required>
			</div>
			<div class="form-group">
				<textarea class="form-control address" rows="3" type="textarea" name="address" placeholder="Branch Address" required></textarea>
			</div>
			<div class="form-group">
				<input class="form-control telephone" type="text" name="telephone" id="telephone" placeholder="Telephone Number" required>
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<center>
				<div class="form-group">
				<button class="btn btn-success action" type="submit" name="action" value="add">Add New Branch</button>
				</div>
			</center>
			</div>
			@if (Session::has('flash_message'))
					<p>{{Session::get('flash_message') }}</p>
			@endif
			{{ Form::close() }}
			</div>
			<hr class="style-fade">	
			</div>
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Branch Name</th>
                      <th>Branch Address</th>
                      <th>Telephone</th>
                      <th>Edit/Delete</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Branches as $Branch)
                    	<tr>
                          	<td>{{$Branch->BranchName}}</td>
                          	<td>{{$Branch->BAddress}}</td>
                          	<td>{{$Branch->Telephone}}</td>
                          	<td><center><button class="btn btn-warning btn-sm" onclick="triggerEditBranch({{$Branch->id}})"><span class="glyphicon glyphicon-cog"></span></button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>