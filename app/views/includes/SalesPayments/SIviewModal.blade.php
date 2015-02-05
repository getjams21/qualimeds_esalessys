<!-- VIEW BILL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="viewSPModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Payment No. <i id="vwbillNo"></i> Details
          <b  class="pull-right" >Payment Date: <i id="paymentDate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
              <br> 
               <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Customer: 
               </span>
                {{Form::select('vwbillSPCustomers', $customers, 'key', array('class' => 'form-control square','id'=>'billSPCustomers','disabled'=>'disabled'));}}
              </div>
             </div>  
             <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Branch: 
               </span>
                {{Form::select('vwbillSPBranch', $branches, 'key', array('class' => 'form-control square','id'=>'billSPBranch','disabled'=>'disabled'));}}
              </div>
             </div>  
          </div> 
            <div class="col-md-3"></div>
            <div class="col-md-4"><br>
             <!--  -->
             <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Prepared By: </span>
                  <input type="text" id="vwSPPreparedBy" class="form-control" readonly >
                </div>
              </div>
            <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Approved By: </span>
                  <input type="text" id="vwSPApprovedBy" class="form-control" readonly >
                </div>
              </div> 
            </div>
            <div class="col-md-1">
            </div>
            </div> 
          </div>
          <div class="panel-body">
            <div class="table-responsive responsive" >
              <table class="table table-striped table-bordered table-hover BillSPTable">
                <thead>
                  <tr>
                  <th>Item #</th>
                  <th>Invoice No.</th>
                  <th>Customer</th>
                  <th>Med Rep</th>
                  <th>RefDoc No</th>
                  <th>Amount</th>
                  </tr>
                 </thead> 
                 <tbody>
                 </tbody>
              </table>
              </div> <!-- table responsive-->
              <hr class="style-fade">
              <div class="row">
                <div class="col-md-9">
                </div>
                <div class="col-md-3">
                  <b>Total Cost:  <i id="vwBillSPTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            <!-- CASH and CHECK table -->
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <div class="well ">
                  <div class="table-responsive responsive" >
                    <table class="table table-striped table-bordered table-hover BillSPPaymentType"
                    >
                      <thead>
                        <tr>
                          <th>Type</th>
                          <th>Bank</th>
                          <th>CheckNo</th>
                          <th>Due Date</th>
                          <th>Amount</th>
                        </tr>
                       </thead> 
                       <tbody>
                       </tbody>
                       <tfoot>
                          <tr>
                            <td colspan="4" class="dp"><b>TOTAL:</b></td>
                            <td><i id="pTTotal">0.00</i></td>
                          </tr>
                       </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
             <!-- END of CASH and CHECK table -->

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