<div class="panel panel-success">
	<div class="panel-heading head">
		<b>Product Categories</b>
	</div>
	<div class="panel-body">	
		<div class="form-group">
			<div class="input-group">
			  <span class="input-group-addon">New</span>
			  <input type="text" id="ProductCategory" class="form-control" placeholder="Product Category" >
			<span class="input-group-addon green hand" id="saveCategory">Save Category</span>
			</div>
		</div>
		<span class="error hidden" id="catError"></span>
	    <hr>
		<div class="table-responsive" >
		  <table class="table table-striped table-bordered table-hover category">
		    <thead>
		      <tr>
		      	<th >No</th>
		        <th>Category Name</th>
		        <th>Update</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($categories as $category)
		          <tr id="category{{$category->id}}"> 
		          	<td >{{$category->id}}</td>
		            <td id="catName{{$category->id}}">
		              {{$category->ProdCatName}}
		            </td>
		            <td>
		            	 <button class="btn btn-success btn-xs" onclick="editCategory({{$category->id}})"><i class="fa fa-cog"></i> Edit</button>
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		  </table>
		</div>
		
	</div>
</div>