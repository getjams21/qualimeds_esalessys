<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Purchase Order List</b></h4>
           </div>
           <div class="col-md-3">
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
		<div class="table-responsive responsive" >
			<div class="well">
				<div class="row">
					<div class="col-md-8">
						<b>Logged in as: &nbsp;&nbsp;</b><i>{{fullame(Auth::user())}}</i>
					</div>
					<div class="col-md-4">
						<b>Date Filter: </b><p id="platformsFilter" ></p>
					</div>
				</div>
			</div>
		  <table class="table table-striped table-bordered table-hover POList">
			
		    <thead>
		      <tr>
		      	<th>PO No</th>
		        <th>Supplier</th>
		        <th>PO Date</th>
		        <th>Terms</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($POs as $PO)
		          <tr > 
		          	<td>{{$PO->id}}</td>
		            <td>{{$PO->SupplierName}}</td>
		            <td>{{dateformat($PO->PODate)}}</td>
		            <td>@if($PO->Terms == 0)
		            	Cash
		            	@else
		            	{{$PO->Terms}} days
		            	@endif
		            </td>
		            <td>{{$PO->PreparedBy}}</td>
		            <td>@if($PO->ApprovedBy)
		            	{{$PO->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>@if($PO->CancelledBy)
		            	{{$PO->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		           
		            
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>