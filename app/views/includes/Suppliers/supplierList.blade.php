<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Suppliers</b></h4>
           </div>
           <div class="col-md-3">
             <button type="button" class="btn btn-success pull-right square" style="white-space: normal;" id="addSupplier"><i class="fa fa-plus-square" ></i> <b> New Supplier</b></button>
           </div>
           </div>
		</div>
	<div class="panel-body">
		@if (Session::has('flash_message'))
			<div class="form-group ">
				<p>{{Session::get('flash_message') }}</p>
			</div>
		@endif
	    <hr>
		<div class="table-responsive" >
		  <table class="table table-striped table-bordered table-hover supplier">
		    <thead>
		      <tr>
		      	<th>No</th>
		        <th>Supplier Name</th>
		        <th>Address</th>
		        <th>Telephone 1</th>
		        <th>Telephone 2</th>
		        <th>Contact Person</th>
		        <th>Update</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($suppliers as $supplier)
		          <tr id="supplier{{$supplier->id}}"> 
		          	<td>{{$supplier->updated_at}}</td>
		            <td>{{$supplier->SupplierName}}</td>
		            <td>{{$supplier->Address}}</td>
		            <td>{{$supplier->Telephone1}}</td>
		            <td>{{$supplier->Telephone2}}</td>
		            <td>{{$supplier->ContactPerson}}</td>
		            <td>
		            	<button class="btn btn-success btn-xs square" onclick="editSupplier({{$supplier->id}})"><i class="fa fa-cog"></i> Edit</button>
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		  </table>
		</div>
		
	</div>
</div>