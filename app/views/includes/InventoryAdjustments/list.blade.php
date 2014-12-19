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
		      	<th>Adjustment No</th>
		        <th>Branch</th>
		        <th>Adjustment Date</th>
		        <th>Remarks</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($IAs as $IA)
		          <tr class="
		         <?php if($IA->IsCancelled == 1){ echo "danger";}elseif($IA->ApprovedBy != '' ){echo "success";}elseif($IA->IsCancelled == 0 && $IA->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$IA->id}}</td>
		            <td>{{$IA->BranchName}}</td>
		            <td>{{dateformat($IA->AdjustmentDate)}}</td>
		            <td id="td-remarks" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$IA->Remarks}}">
		            	<?php 
			            	// strip tags to avoid breaking any html
							$remarks = strip_tags($IA->Remarks);
							if (strlen($remarks) > 25) {
							    // truncate remarks
							    $remarksCut = substr($remarks, 0, 25);
							    // make sure it ends in a word so assassinate doesn't become ass...
							    $remarks = substr($remarksCut, 0, strrpos($remarksCut, ' ')).'...'; 
							}
		            	 ?>
		            	{{$remarks}}
		            </td>
		            <td >{{$IA->PreparedBy}}</td>
		            <td  id="App{{$IA->id}}">@if($IA->ApprovedBy)
		            	{{$IA->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$IA->id}}">@if($IA->CancelledBy)
		            	{{$IA->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($IA->ApprovedBy == '' || isAdmin())  && ($IA->CancelledBy == '' ) && !$IA->billed)
		              <button class="btn btn-primary btn-xs "  onclick="editIA({{$IA->id}})"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs "  onclick="viewIA({{$IA->id}})"> View</button>
		              @endif
		            </td>
		           
		            
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>