<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="billPOModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title"><i id="billNo">New Bill</i> Details
          <b  class="pull-right" >Date:&nbsp;&nbsp;{{date('F d, Y')}}</b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
             <h4> Purchase Order No: <i id="billPOId"></i><br></h4>
               <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Sales Invoice No. : </span>
                  <input type="text" id="invoiceno" class="form-control" >
                </div>
              </div>
              {{ Form::label('', 'Sales Invoice Date: '); }}
                    <div class="input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$now}}" type="text" id="invoicedate"  readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
             
          </div> 
            <div class="col-md-3"></div>
            <div class="col-md-4"><br>
              <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Supplier: 
               </span>
                {{Form::select('billPOSupplier', $supplier, 'key', array('class' => 'form-control square','id'=>'billPOSupplier','disabled'=>'disabled'));}}
              </div>
             </div>
             <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Branch: </span>
                  <input type="text" id="billBranchName" class="form-control" readonly >
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                {{Form::label('billterm', 'Terms :&nbsp;&nbsp;&nbsp;')}}
                <div class="btn-group square " data-toggle="buttons">
                  <button class="btn btn-success square panel-head dis" id="billTerm1" >
                   Cash </button>
                  <button class="btn btn-success square panel-head dis" id="billTerm2" >
                    Term  </button>
                  <div class="input-group hidden" id="billTermBox" >
                    <input type="number" min="1" name="billterm" id="billTerm" class="form-control square dis" style="width:80px;" required >
                    <span class="input-group-addon square">days</span>
                  </div>
               </div>
               <p id="termError" class="error" hidden> Please enter a valid term days.</p>
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
              <table class="table table-striped table-bordered table-hover BillPOTable">
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
                  <b>Total Cost:  <i id="billPOTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
           <button type="button" class="btn btn-success hidden pull-left" id="saveBillPOBtn">Bill PO</button>
        <button type="button" class="btn btn-danger  pull-left" id="BillCancelBtn">Cancel Bill</button>
           @if(isAdmin())
           <span class="alert alert-warning" id="checkAlert"> Approval status will be automatically updated upon clicking the checkbox.</span>
           <input type="checkbox" id="billApprove" style="width:18px; height:15px;"/> 
           <input type="checkbox" id="billApproved" style="width:18px; height:15px;"/> Approved
           @endif
           &nbsp;&nbsp;
        <button type="button" class="btn btn-success hidden " id="vwSaveBillBtn">Save</button>  
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- VIEW BILL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="viewBillModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Bill No. <i id="vwbillNo"></i> Details
          <b  class="pull-right" >Bill Date: <i id="billDate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
             <h4> Purchase Order No: <i id="vwbillPOId"></i><br></h4>
               <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Invoice No: </span>
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
                Supplier: 
               </span>
                {{Form::select('vwBillSupplier', $supplier, 'key', array('class' => 'form-control square','id'=>'vwBillSupplier','disabled'=>'disabled'));}}
              </div>
             </div>
             <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Branch: </span>
                  <input type="text" id="vwBillBranchName" class="form-control" readonly >
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
              <table class="table table-striped table-bordered table-hover BillPOTable2">
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