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
			{{ Form::open(['route'=>'users.store', 'id'=>'customerForm']) }}
			<div class="form-group">
				<label>Username</label>
				<input class="form-control username" type="text" name="username" placeholder="Username" required>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control password" name="password" placeholder="Password" required></textarea>
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
				<input class="form-control mi" type="text" name="mi" id="mi" placeholder="Middle Initial" required>
			</div>
			<div class="form-group">
				<label>User Type</label>
				<select class="form-control">
				  <option class="" value="1">Admin</option>
				  <option class="" value="11">Admin/Sales Rep</option>
				  <option class="" value="2">Warehouse</option>
				  <option class="" value="3">Office Clerk</option>
				  <option class="" value="4">Sales Rep</option>
				</select>
				<input type="hidden" name="id" id="library-action" value="">
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
			<font size="5">Customers</font>
			<button class="btn btn-success add-bank pull-right square" data-toggle="modal" data-target="#customer-library">
		  	<span class="glyphicon glyphicon-plus"></span> New Customer
			</button>
		</div>
	</div>
	<div class="panel-body">	
		<div class="container-fluid">
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer's Address</th>
                      <th>Telephone 1</th>
                      <th>Telephone 2</th>
                      <th>Contact Person</th>
                      <th>Credit Limit</th>
                      <th>Edit/Delete</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Customers as $Customer)
                    	<tr>
                          	<td>{{$Customer->CustomerName}}</td>
                          	<td>{{$Customer->Address}}</td>
                          	<td>{{$Customer->Telephone1}}</td>
                          	<td>{{$Customer->Telephone2}}</td>
                          	<td>{{$Customer->ContactPerson}}</td>
                          	<td>{{$Customer->CreditLimit}}</td>
                          	<td><center><button class="btn btn-success btn-sm" onclick="triggerEditCustomer({{$Customer->id}})"><span class="glyphicon glyphicon-cog"></span> Edit</button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>