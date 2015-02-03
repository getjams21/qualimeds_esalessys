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
		<!-- success alert -->
		<div class="alert alert-success SOsaved" role="alert" hidden>
		  Sales Order is Successfully Saved!
		</div>
		@if (Session::has('flash_message'))
			<div class="form-group ">
				<p>{{Session::get('flash_message') }}</p>
			</div>
		@endif
		<div class="table-responsive responsive" >
			 
		  <table class="table  table-bordered table-hover" id="SOList">
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
		      	<th>Customer Return No.</th>
		      	<th>SalesInvoice No.</th>
		        <th>Branch</th>
		        <th>Customer Return Date</th>
		        <th>Remarks</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($CRs as $CR)
		          <tr class="
		         <?php if($CR->IsCancelled == 1){ echo "danger";}elseif($CR->ApprovedBy != '' ){echo "success";}elseif($CR->IsCancelled == 0 && $CR->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$CR->id}}</td>
		            <td>{{$CR->SalesinvoiceNo}}</td>
		            <td>{{$CR->BranchNo}}</td>
		            <td>{{dateformat($CR->AdjustmentDate)}}</td>
		            <td id="td-remarks" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$CR->Remarks}}">
		            	<?php 
			            	// strip tags to avoid breaking any html
							$remarks = strip_tags($CR->Remarks);
							if (strlen($remarks) > 25) {
							    // truncate remarks
							    $remarksCut = substr($remarks, 0, 25);
							    // make sure it ends in a word so assassinate doesn't become ass...
							    $remarks = substr($remarksCut, 0, strrpos($remarksCut, ' ')).'...'; 
							}
		            	 ?>
		            	{{$remarks}}
		            </td>
		            <td >{{$CR->PreparedBy}}</td>
		            <td  id="App{{$CR->id}}">@if($CR->ApprovedBy)
		            	{{$CR->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$CR->id}}">@if($CR->CancelledBy)
		            	{{$CR->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($CR->ApprovedBy == '' || isAdmin())  && ($CR->CancelledBy == '' ) && !$CR->billed)
		              <button class="btn btn-primary btn-xs "  onclick="editCR({{$CR->id}})"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs "  onclick="viewCR({{$CR->id}})"> View</button>
		              @endif
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>