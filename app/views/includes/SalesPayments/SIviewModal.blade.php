<!-- VIEW BILL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="viewSIModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Invoice No. <i id="vwbillNo"></i> Details
          <b  class="pull-right" >Invoice Date: <i id="billDate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
             <h4> Sales Order Order No: <i id="vwbillSOId"></i><br></h4>
               <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Ref Doc No: </span>
                  <input type="text" id="vwBillInvoiceNo" class="form-control" readonly >
                </div>
              </div>
            <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Invoice Date: </span>
                  <input type="text" id="vwBillInvoiceDate" class="form-control" readonly >
                </div>
              </div>
             
          </div> 
            <div class="col-md-3"></div>
            <div class="col-md-4"><br>
              <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Customer: 
               </span>
                {{Form::select('vwbillSOCustomers', $customers, 'key', array('class' => 'form-control square','id'=>'billSOCustomers','disabled'=>'disabled'));}}
              </div>
             </div>
             <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Customer: 
               </span>
                {{Form::select('vwbillSOmedReps', $medReps, 'key', array('class' => 'form-control square','id'=>'billSOmedReps','disabled'=>'disabled'));}}
              </div>
             </div>
             <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Term: </span>
                  <input type="text" id="vwBillTerm" class="form-control" readonly >
                </div>
              </div>
            </div>
            <div class="col-md-1">
            </div>
            </div> 
          </div>
          <div class="panel-body">
            <div class="alert alert-danger" hidden id="billError"><center><b>Please fill out Invoice No. / Invoice Date</b></center></div>
            <div class="table-responsive responsive" >
              <table class="table table-striped table-bordered table-hover BillSOTable2">
                <thead>
                  <tr><th colspan="10" class="success">Billing Details</th>
                      <th colspan="3" class="warning">Freebies</th>
                  </tr>
                  <tr>
                    <th>Item #</th>
                    <th>Prod. #</th>
                    <th>Prod. Name</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th>Lot No.</th>
                    <th>Exp. Date</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Item Cost</th>
                    <th>Qty</th>
                    <th>Unit</th>
                  </tr>
                 </thead> 
                 <tbody>
                 </tbody>
              </table>
              </div> <!-- table responsive-->
              <hr class="style-fade">
              <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                  <b>Total Cost:  <i id="vwBillTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
          
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>