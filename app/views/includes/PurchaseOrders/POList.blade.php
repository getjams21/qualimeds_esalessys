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
		  <table class="table table-striped table-bordered table-hover POList">
		    <thead>
		      <tr>
		      	<th>No</th>
		        <th>Prod. Category</th>
		        <th>Prod. Name</th>
		        <th>Brand Name</th>
		        <th>Wholesale Unit</th>
		        <th>Retail Unit</th>
		        <th>Rtl.Qty/WhlSale Unit</th>
		        <th>Markup1</th>
		        <th>Markup2</th>
		        <th>Markup3</th>
		        <th>Active Markup</th>
		        <th>Update</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($POs as $PO)
		          <tr id="product{{$product->id}}"> 
		          	<td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td>
		            	<button class="btn btn-success btn-xs square"><i class="fa fa-cog"></i> Edit</button>
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		  </table>
		</div>
		
	</div>
</div>