
<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Sales Order List</b></h4>
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
		<div class="table-responsive responsive" >
		  <table class="table table-striped table-bordered table-hover" id="SOList">
		  	<div class="row">
		  		<!-- <div class="col-md-5">
		  		<br>
		         </div>	 -->
		         <div class="col-md-11">
		         	<br>
		  		 	 <div class="form-group pull-left" >
		                <div class="input-group" style="width:50%;  ">
		                  <span class="input-group-addon">Search Keyword: </span>
		                  <input type="text" id="mySearchTextField" class="form-control"  >
		                </div>
		         	</div> 
		         </div>	
		     </div>   	
			<thead>
		      <tr>
		      	<th>SO No</th>
		        <th>SO Date</th>
		        <th>Terms</th>
		        <th>Customer</th>
		        <th>Sales Rep</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($SOs as $SO)
		          <tr class="
		         <?php if($SO->IsCancelled == 1){ echo "danger";}elseif($SO->ApprovedBy != ''){echo "success";}elseif($SO->IsCancelled == 0 && $SO->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$SO->id}}</td>
		            <td>{{dateformat($SO->SalesOrderDate)}}</td>
		            <td>@if($SO->Terms == 0)
		            	Cash
		            	@else
		            	{{$SO->Terms}} days
		            	@endif
		            </td>
		            <td>{{$SO->CustomerName}}</td>
		            <td> {{ucfirst($SO->Lastname)}},&nbsp;{{ucfirst($SO->Firstname)}}&nbsp;{{ucfirst($SO->MI)}}.</td>
		            <td >{{$SO->PreparedBy}}</td>
		            <td  id="App{{$SO->id}}">@if($SO->ApprovedBy)
		            	{{$SO->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		              <button class="btn btn-success btn-xs "  onclick="billSO({{$SO->id}})"><i class="fa fa-check"></i>Bill</button>
		            </td>
		           
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>