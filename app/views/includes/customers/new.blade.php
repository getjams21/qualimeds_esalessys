<!-- Customer Add Modal -->
<div class="modal fade" id="customer-library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Customers</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        	<div class="col-md-12">
			<div class="well customerForm">
			<div>
			{{ Form::open(['route'=>'customers.store', 'id'=>'customerForm']) }}
			<div class="form-group">
				<label>Customer Name</label>
				<input class="form-control name" type="text" name="CustomerName" placeholder="Customer Name" required>
			</div>
			<div class="form-group">
				<label>Customer Address</label>
				<textarea class="form-control address" rows="3" name="Address" placeholder="Customer's Address" required></textarea>
			</div>
			<div class="form-group">
				<label>Telephone 1</label>
				<input class="form-control telephone1" type="text" name="Telephone1" id="telephone1" placeholder="Telephone 1" required>
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<div class="form-group">
				<label>Telephone 2</label>
				<input class="form-control telephone2" type="text" name="Telephone2" id="telephone2" placeholder="Telephone 2">
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
			<div class="form-group">
				<label>Contact Person</label>
				<input class="form-control contact-person" type="text" name="ContactPerson" id="contact-person" placeholder="Contact Person" required>
			</div>
			<div class="form-group">
				<label>Credit Limit</label>
				<input class="form-control credit-limit" type="text" name="CreditLimit" id="credit-limit" placeholder="Credit Limit" required>
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
		<h4>Customers</h4>
	</div>
	<div class="panel-body">
		<!-- Button trigger modal -->
		<center><button class="btn btn-primary add-customer" data-toggle="modal" data-target="#customer-library">
		  New Customer
		</button></center>
		<br>
		<hr class="style-fade">	
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