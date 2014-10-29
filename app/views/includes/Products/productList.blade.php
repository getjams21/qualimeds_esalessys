<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Product</b></h4>
           </div>
           <div class="col-md-3">
             <button type="button" class="btn btn-success pull-right square" style="white-space: normal;" id="addProduct"><i class="fa fa-plus-square" ></i> <b> New Product</b></button>
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
		  <table class="table table-striped table-bordered table-hover product">
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
		         @foreach($products as $product)
		          <tr id="product{{$product->id}}"> 
		          	<td>{{$product->id}}</td>
		            <td>{{$product->ProdCatName}}</td>
		            <td>{{$product->ProductName}}</td>
		            <td>{{$product->BrandName}}</td>
		            <td>{{$product->WholeSaleUnit}}</td>
		            <td>{{$product->RetailUnit}}</td>
		            <td>{{$product->RetailQtyPerWholeSaleUnit}}</td>
		            <td>{{$product->Markup1}}</td>
		            <td>{{$product->Markup2}}</td>
		            <td>{{$product->Markup3}}</td>
		            <td>{{$product->ActiveMarkup}}</td>
		            <td>
		            	<button class="btn btn-success btn-xs square" onclick="editProduct({{$product->id}})"><i class="fa fa-cog"></i> Edit</button>
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		  </table>
		</div>
		
	</div>
</div>