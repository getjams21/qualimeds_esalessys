<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="row">
            <div class="col-md-9">
              <h4><b>Bill Payments</b></h4>
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
			 
		  <table class="table table-striped table-bordered table-hover" id="billPaymentsList">
		  	<div class="row">
		         <div class="col-md-11">
		         	<div class="input-group ">
                  	{{ Form::label('', 'From: '); }}
	                    <div class="input-group date txtbox-m" id="grp-from" data-date="" >
	                      <input class="form-control" value="{{$lastweek}}" type="text" id="min"  readonly required>
	                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
	                    </div>
                    {{ Form::label('', 'To: '); }}
	                     <div class="input-group date txtbox-m" id="grp-from" data-date="" >
	                      <input class="form-control" value="{{$now}}" type="text" id="max"  readonly required>
	                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
	                    </div>
                    </div>
		        	<br>
		  		 	 <div class="form-group pull-left" >
		                <div class="input-group" style="width:50%;  ">
		                  <span class="input-group-addon">Search Keyword: </span>
		                  <input type="text" id="billPaymentSearch" class="form-control"  >
		                </div>
		         	</div> 
		         </div>	
		     </div>   	
			<thead>
		      <tr>
		      	<th>BillPayment No</th>
		        <th>Payment Date</th>
		        <th>Payment Type</th>
		        <th>Amount</th>
		        <th>Pay To</th>
		        <th>Prepared By</th>
		        <th>Approved By</th>
		        <th>Cancelled By</th>
		        <th>Action</th>
		      </tr>
		     </thead> 
		     <tbody>
		         @foreach($billpayments as $billpayment)
		          <tr class="
		         <?php if($billpayment->IsCancelled == 1){ echo "danger";}elseif($billpayment->ApprovedBy != ''){echo "success";}else if($billpayment->IsCancelled == 0 && $billpayment->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$billpayment->id}}</td>
		            <td>{{dateformat($billpayment->PaymentDate)}}</td>
		            <td>@if($billpayment->PaymentType == 0)
		            	Cash
		            	@else
		            	Cheque
		            	@endif
		           	</td>
		            <td>{{$billpayment->amount}}</td>
		            <td>@if($billpayment->PayTo)
		            	{{$billpayment->PayTo}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		             <td >{{$billpayment->PreparedBy}}</td>
		            <td  id="App{{$billpayment->id}}">@if($billpayment->ApprovedBy)
		            	{{$billpayment->ApprovedBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td  id="CancelledBy{{$billpayment->id}}">@if($billpayment->CancelledBy)
		            	{{$billpayment->CancelledBy}}
		            	@else
		            	N/A
		            	@endif
		            </td>
		            <td>
		             @if(($billpayment->ApprovedBy == '' || isAdmin()) && ($billpayment->CancelledBy == ''))
		              <button class="btn btn-primary btn-xs editBillPayment" value="{{$billpayment->id}}"><i class="fa fa-gear"></i>Edit</button>
		              @else
		             <button class="btn btn-success btn-xs viewBillPayment" value="{{$billpayment->id}}" > View</button>
		              @endif
		            </td>
		         </tr> 
		        @endforeach
		      </tbody>
		  </table>
		</div>
		
	</div>
</div>
