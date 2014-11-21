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
			 
		  <table class="table table-striped table-bordered table-hover" id="POList">
		  	<div class="row">
		  		<!-- <div class="col-md-5">
		  			
		  		<br>
		         </div>	 -->
		         <div class="col-md-11">
		         	<div class="input-group ">
                  	{{ Form::label('', 'From: '); }}
                    <div class="input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$lastweek}}" type="text" id="min"  readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    {{ Form::label('', 'To: '); }}
                     <div class="input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$now}}" type="text" id="max"  max="{{$now}}" readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    </div><br>
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
		      	<th>PO No</th>
		        <th>Supplier</th>
		        <th>PO Date</th>
		        <th>Terms</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($POs as $PO)
		          <tr class="
		         <?php if($PO->IsCancelled == 1){ echo "danger";}elseif($PO->ApprovedBy != ''){echo "success";}elseif($PO->IsCancelled == 0 && $PO->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$PO->id}}</td>
		            <td>{{$PO->SupplierName}}</td>
		            <td>{{dateformat($PO->PODate)}}</td>
		            <td>@if($PO->Terms == 0)
		            	Cash
		            	@else
		            	{{$PO->Terms}} days
		            	@endif
		            </td>
		            <td >{{$PO->PreparedBy}}</td>
		            <td  id="App{{$PO->id}}">@if($PO->ApprovedBy)
		            	{{$PO->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$PO->id}}">@if($PO->CancelledBy)
		            	{{$PO->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($PO->ApprovedBy == '' || isAdmin()) && ($PO->CancelledBy == ''))
		              <button class="btn btn-primary btn-xs "  onclick="editPO({{$PO->id}})"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs "  onclick="viewPO({{$PO->id}})"> View</button>
		              @endif
		            </td>
		           
		            
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>