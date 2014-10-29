<div class="panel panel-success">
	<div class="panel-heading head">
		<h4>Banks</h4>
	</div>
	<div class="panel-body">
		<center><h4>New Bank</h4></center>
		<hr class="style-fade">	
		<div class="container-fluid">
			<div class="col-md-8 col-md-offset-2">
			<div class="well bankForm">
			<div>
			{{ Form::open(['route'=>'banks.store']) }}
			<div class="form-group">
				<input class="form-control name" type="text" name="name" placeholder="Bank Name" required>
			</div>
			<div class="form-group">
				<input class="form-control address" type="textarea" name="address" placeholder="Bank Address" required>
			</div>
			<div class="form-group">
				<input class="form-control telephone" type="text" name="telephone" id="telephone" placeholder="Telephone Number" required>
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<center>
				<div class="form-group">
				<button class="btn btn-success action" type="submit" name="action" value="add">Add New Bank</button>
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
                      <th>Bank Name</th>
                      <th>Bank Address</th>
                      <th>Telephone</th>
                      <th>Edit/Delete</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Banks as $Bank)
                    	<tr>
                          	<td>{{$Bank->BankName}}</td>
                          	<td>{{$Bank->BAddress}}</td>
                          	<td>{{$Bank->Telephone}}</td>
                          	<td><center><button class="btn btn-warning btn-sm" onclick="triggerEdit({{$Bank->id}})"><span class="glyphicon glyphicon-cog"></span></button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>