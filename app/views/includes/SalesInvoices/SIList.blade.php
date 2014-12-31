<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Sales Invoices</b></h4>
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
			 
		  <table class="table table-striped table-bordered table-hover" id="billListing">
		  	<div class="row">
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
		                  <input type="text" id="billSearchTextField" class="form-control"  >
		                </div>
		         	</div> 
		         </div>	
		     </div>   	
			<thead>
		      <tr>
		      	<th>Invoice No</th>
		        <th>SO #</th>
		        <th>Invoice Date</th>
		        <th>Invoice No.</th>
		        <th>Terms</th>
		        <th>Customer</th>
		        <th>Med Rep</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($SIs as $bill)
		          <tr class="
		         <?php if($bill->IsCancelled == 1){ echo "danger";}elseif($bill->ApprovedBy != ''){echo "success";}elseif($bill->IsCancelled == 0 && $bill->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$bill->id}}</td>
		            <td>{{$bill->SalesOrderNo}}</td>
		            <td>{{dateformat($bill->InvoiceDate)}}</td>
		            <td>{{$bill->SalesInvoiceRefDocNo}}</td>
		            <td>@if($bill->Terms==0)
		            	Cash
		            	@else
		            	{{$bill->Terms}}
		            	@endif
		            </td>
		            <td>{{$bill->CustomerName}}</td>
		            <td>{{ucfirst($bill->Lastname)}},&nbsp;{{ucfirst($bill->Firstname)}}&nbsp;{{ucfirst($bill->MI)}}.</td>
		            <td >{{$bill->PreparedBy}}</td>
		            <td  id="App{{$bill->id}}">@if($bill->ApprovedBy)
		            	{{$bill->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$bill->id}}">@if($bill->CancelledBy)
		            	{{$bill->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($bill->ApprovedBy == '' || isAdmin()) && ($bill->CancelledBy == ''))
		              <button class="btn btn-primary btn-xs "  onclick="editSI({{$bill->id}})"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs "  onclick="viewSI({{$bill->id}})"> View</button>
		              @endif
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		      
		  </table>
		</div>
		
	</div>
</div>