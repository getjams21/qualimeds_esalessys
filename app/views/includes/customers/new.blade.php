<div class="panel panel-success">
	<div class="panel-heading head">
		<h4>Customers</h4>
	</div>
	<div class="panel-body">
		<center><h4>New Customer</h4></center>
		<hr class="style-fade">	
		<div class="container-fluid">
			<div class="col-md-8 col-md-offset-2">
			<div class="well customerForm">
			<div>
			{{ Form::open(['route'=>'customers.store']) }}
			<div class="form-group">
				<input class="form-control name" type="text" name="name" placeholder="Customer Name" required>
			</div>
			<div class="form-group">
				<textarea class="form-control address" rows="3" name="address" placeholder="Customer's Address" required></textarea>
			</div>
			<div class="form-group">
				<input class="form-control telephone1" type="text" name="telephone1" id="telephone1" placeholder="Telephone 1" required>
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<div class="form-group">
				<input class="form-control telephone2" type="text" name="telephone2" id="telephone2" placeholder="Telephone 2">
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<div class="form-group">
				<input class="form-control contact-person" type="text" name="contact-person" id="contact-person" placeholder="Contact Person" required>
			</div>
			<div class="form-group">
				<input class="form-control credit-limit" type="text" name="credit-limit" id="credit-limit" placeholder="Credit Limit" required>
			</div>
			<center>
				<div class="form-group">
				<button class="btn btn-success action" type="submit" name="action" value="add">Add New Customer</button>
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
                          	<td><center><button class="btn btn-warning btn-sm" onclick="triggerEditCustomer({{$Customer->id}})"><span class="glyphicon glyphicon-cog"></span></button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>