<div class="panel panel-success">
	<div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Sales Payment Entry No. <i class="billPaymentEditId">{{$max+1}}</i></b>
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
              <center>Select Invoice for Payment </center>
          </div>
          <div id="BillPaymentEditing" class="hidden">
	          <div class="alert alert-danger">
	              <center>You are currently Editing Existing Invoice Payment No. <i class="billPaymentEditId" ></i></center>
	          </div>
	          <input type="hidden"  id="SPediting">
            <input type="hidden"  id="customer_id">
	         <span class="pull-right"> <input type="button" class="btn btn-warning" id="cancelBPEditing" value="Cancel Editing"></span>
	      </div>
        </div>
       <div class="col-md-8">
      <div class="form-group" style="width:80%;">
              <div class="input-group">
                <span class="input-group-addon">Search Invoice: </span>
                <input type="text" id="myInputTextField" class="form-control"  >
              </div>
       </div>
      <div class=" responsive" >
              <table class="table table-striped table-bordered table-hover Bills">
                <thead>
                  <tr>
                    <th>Invoice #</th>
      			        <th>SO #</th>
      			        <th>Customer</th>
      			        <th>Med Rep</th>
      			        <th>RefDoc</th>
      			        <th>Invoice Date</th>
      			        <th>Terms</th>
                    <th>Amount</th>
      			        <th>Action</th>
                  </tr>
                 </thead> 
                 <tbody>
                  @foreach($invoices as $bill)
                    <tr class="
		         <?php if($bill->IsCancelled == 1){ echo "danger";}elseif($bill->ApprovedBy != ''){echo "success";}elseif($bill->IsCancelled == 0 && $bill->ApprovedBy == ''){echo "warning";}?>
		          "> 
		          	<td>{{$bill->id}}</td>
		            <td>{{$bill->SalesOrderNo}}</td>
		            <td>{{$bill->CustomerName}}</td>
		            <td>{{fullname($bill)}}</td>
		            <td>{{$bill->SalesInvoiceRefDocNo}}</td>
		            <td>{{dateformat($bill->SalesInvoiceDate)}}</td>
		            <td>@if($bill->Terms == 0)
		            	Cash
		            	@else
		            	{{$bill->Terms}} days
		            	@endif
		            </td>
                <td class="dp">{{money($bill->amount)}}</td>
		            <td>
		            	<button class="btn btn-success btn-xs "  onclick="viewSI({{$bill->id}})"> View</button>
		            	<button class="btn btn-primary btn-xs "  onclick="addSItoSP({{$bill->id}})"> <i class="fa fa-check-circle">Add</i></button>
		            </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div>
            <div class="error" id="billError1" hidden> Invoice already added</div>
            <div class="error" id="billSupError1" hidden> Invoice has different Customer</div>
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
            <th>Invoice No.</th>
            <th>Customer</th>
            <th>Med Rep</th>
            <th>RefDoc No</th>
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
     <!-- CASH and CHECK table -->
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="error" id="checkBoxError" hidden>Payment must be greater or equal to the Total Bill.</div>
        <div class="well hidden cashChecque">
          <div class="table-responsive responsive" >
            <table class="table table-striped table-bordered table-hover"
            id="cashCheckTable">
              <thead>
                <tr>
                  <th colspan="5">
                    <div class="input-group" >
                   <span class="input-group-addon panel-head square">
                    Payment Type: 
                   </span>
                      <select id="paymentType" class="form-control square" style="width:200%;">
                        <option value="0">Cash</option>
                        <option value="1">Check</option>
                      </select>
                    </div>
                  </th>
                  <th>
                    <input type="button"  class="btn btn-primary btn-md square"  onclick="addPaymentType()" value='Add Payment'> </button>
                  </th>
                </tr>
                <tr>
                  <th>Type</th>
                  <th>Bank</th>
                  <th>CheckNo</th>
                  <th>Due Date</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
               </thead> 
               <tbody>
               </tbody>
               <tfoot>
                  <tr>
                    <td colspan="4" class="dp"><b>TOTAL:</b></td>
                    <td><i id="paymentTypeTotal">0.00</i></td>
                    <td></td>
                  </tr>
               </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
     <!-- END of CASH and CHECK table -->
    <div class="row">
      <div class="col-md-12">
        <div class="well">
          <div class="row">
            <div class="col-md-7">
            <b>Prepared By: <i id="preparedBy">{{fullname(Auth::user())}}</i></b> 
            </div>
            <div class="col-md-3">
              @if(isAdmin())
            <input type="checkbox" id="approvedSP" style="width:15px; height:15px;"/> Approved
             @endif
             </div>
            <div class="col-md-2">
             <button type="button" class="btn btn-success square btn-sm hidden"  id="saveSP" style="margin-right:5%;"><i class="fa fa-plus-square" ></i> <b> Save Payment</b></button>
             </div>
           </div>
        </div>
      </div>
    </div>
    </div>

  {{ Form::close() }}
</div>