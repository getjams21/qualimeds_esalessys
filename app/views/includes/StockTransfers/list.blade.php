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
		  Transfer of Stock is Successfully Saved!
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
		      	<th>ST No</th>
		        <th>Branch Destination</th>
		        <th>Transfer Date</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($STs as $ST)
		          <tr class="
		         <?php if($ST->IsCancelled == 1){ echo "danger";}elseif($ST->ApprovedBy != '' ){echo "success";}elseif($ST->IsCancelled == 0 && $ST->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$ST->id}}</td>
		            <td>{{$ST->BranchName}}</td>
		            <td>{{dateformat($ST->TransferDate)}}</td>
		            <td >{{$ST->PreparedBy}}</td>
		            <td  id="App{{$ST->id}}">@if($ST->ApprovedBy)
		            	{{$ST->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$ST->id}}">@if($ST->CancelledBy)
		            	{{$ST->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($ST->ApprovedBy == '' || isAdmin())  && ($ST->CancelledBy == '' ) && !$ST->billed)
		              <button class="btn btn-primary btn-xs "  onclick="editST({{$ST->id}})"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs "  onclick="viewST({{$ST->id}})"> View</button>
		              @endif
		            </td>
		           
		            
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>