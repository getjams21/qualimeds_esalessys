<div class="panel panel-success">
	<div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Bill Payment Entry No. <i class="billPaymentEditId">{{$max+1}}</i></b>
      </div> 
      <div class="col-md-3" style="padding-top:6px;">
          <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
		<div class="row">
        <div class="col-md-4">
     {{ Form::open() }}
            <br>
          <div class="alert alert-warning">
              <center>Select Bill for Payment </center>
          </div>
          <div id="BillPaymentEditing" class="hidden">
	          <div class="alert alert-danger">
	              <center>You are currently Editing Existing Bill Payment No. <i class="billPaymentEditId" ></i></center>
	          </div>
	          <input type="hidden"  id="BPediting">
	         <span class="pull-right"> <input type="button" class="btn btn-warning" id="cancelBPEditing" value="Cancel Editing"></span>
	      </div>
        </div>
       <div class="col-md-1">
       </div>
       <div class="col-md-7">
      <div class="form-group" style="width:80%;">
              <div class="input-group">
                <span class="input-group-addon">Search Product: </span>
                <input type="text" id="myInputTextField" class="form-control"  >
              </div>
       </div>
      <div class=" responsive" >
              <table class="table table-striped table-bordered table-hover Bills">
                <thead>
                  <tr>
                    <th>Bill No</th>
      			        <th>PO #</th>
      			        <th>Supplier</th>
      			        <th>Invoice No.</th>
      			        <th>Invoice Date</th>
      			        <th>Terms</th>
                    <th>Amount</th>
      			        <th>Action</th>
                  </tr>
                 </thead> 
                 <tbody>
                  @foreach($bills as $bill)
                    <tr class="
		         <?php if($bill->IsCancelled == 1){ echo "danger";}elseif($bill->ApprovedBy != ''){echo "success";}elseif($bill->IsCancelled == 0 && $bill->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$bill->id}}</td>
		            <td>{{$bill->PurchaseOrderNo}}</td>
		            <td>{{$bill->SupplierName}}</td>
		            <td>{{$bill->SalesInvoiceNo}}</td>
		            <td>{{dateformat($bill->SalesInvoiceDate)}}</td>
		            <td>@if($bill->Terms == 0)
		            	Cash
		            	@else
		            	{{$bill->Terms}} days
		            	@endif
		            </td>
                <td class="dp">{{money($bill->amount)}}</td>
		            <td>
		            	<button class="btn btn-success btn-xs "  onclick="viewBill({{$bill->id}})"> View</button>
		            	<button class="btn btn-primary btn-xs "  onclick="addBillToPayment({{$bill->id}})"> <i class="fa fa-check-circle">Add</i></button>
		            </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div>
            <div class="error" id="billError1" hidden> Bill already added</div>
            <div class="error" id="billSupError1" hidden> Bill has different Supplier</div>
      </div>
    </div>
  </div>
    <div class="panel-body">
    <div class="well">
    <div class="table-responsive responsive" >
      <table class="table table-striped table-bordered table-hover BillPaymentTable">
        <thead>
          <tr>
            <th>Item #</th>
            <th>Bill No.</th>
            <th>Supplier</th>
            <th >Invoice No</th>
            <th>Amount</th>
            <th>Remove</th>
          </tr>
         </thead> 
         <tbody>
         </tbody>
      </table>
    </div><hr class="style-fade">
    <div class="row">
      <div class="col-md-8">
      </div>
      <div class="col-md-4">
        <b>Total Amount:  <i id="BillPaymentTotalCost"> 0</i></b>
      </div>
    </div>
    </div>
    <hr >
    <!-- CASH and CHECK START -->
    <div class="row" >
      <div class="col-md-12">
        <div class="well hidden cashChecque">
          <div class="row">
            <div class="col-md-2">
             CASH&nbsp;&nbsp;<input type="radio" checked id="billCash" name="paymentType" style="width:15px; height:15px;"/><br>
             CHEQUE&nbsp;&nbsp;<input type="radio" id="billCheque" name="paymentType" style="width:15px; height:15px;"/>
            </div>
            <div class="col-md-10">
            	<div class="cashDiv container-fluid col-md-5 " >
            		<h4>Cash Details: </h4>
            		<div class="row">
	                    <div class="col-md-6 ">
	                    <div class="input-group">
			                <input type="button" id="cashVoucher" class="form-control btn btn-primary"  value="Cash Voucher">
		              	</div>
		              	</div>
		            </div>
            	</div>
            	<div class="chequeDiv container-fluid col-md-12 hidden" >
              <div class="col-md-6">
            		<h4>Cheque Details: </h4>
            		<div class="input-group">
		               <span class="input-group-addon panel-head square">
		                Bank: 
		               </span>
		               {{Form::select('bankNo', $banks, 'key', array('class' => 'form-control square','id'=>'bankNo'));}}
		          </div><br>
			          <div class="input-group">
		                <span class="input-group-addon panel-head square">Cheque No: </span>
		                <input type="text" id="chequeNo" class="form-control"  >
	              </div>
              </div>
              <div class="col-md-6">
                <br><br>
                  <div class="input-group">
                      <span class="input-group-addon panel-head square">PayTo: </span>
                      <input type="text" id="payTo" class="form-control"  >
                  </div><br>
	                {{ Form::label('', 'Cheque Due Date: '); }}
                    <div class="input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$now}}" type="text" id="chequeDueDate"  readonly required >
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div><br>
		            <div class="error" id="chequeError" hidden>Please provide Pay To, Check No or Check Due Date.</div>
                    <div class="row">
	                    <div class="col-md-6 col-md-offset-6">
	                    <div class="input-group">
			                <input type="button" id="chequeVoucher" class="form-control btn btn-primary"  value="Cheque Voucher">
		              	</div>
		              	</div>
		            </div>
            	</div>
             </div>
             </div>
            <div class="col-md-1">
             </div>
           </div>
        </div>
      </div>
    </div>
     <!-- CASH and CHECK END -->
    <div class="row">
      <div class="col-md-12">
        <div class="well">
          <div class="row">
            <div class="col-md-7">
            <b>Prepared By: <i id="preparedBy">{{fullname(Auth::user())}}</i></b> 
            </div>
            <div class="col-md-3">
              @if(isAdmin())
            <input type="checkbox" id="approvedBillPayment" style="width:15px; height:15px;"/> Approved
             @endif
             </div>
            <div class="col-md-2">
             <button type="button" class="btn btn-success square btn-sm hidden"  id="saveBill" style="margin-right:5%;"><i class="fa fa-plus-square" ></i> <b> Save Payment</b></button>
             </div>
           </div>
        </div>
      </div>
    </div>
    </div>

  {{ Form::close() }}
</div>