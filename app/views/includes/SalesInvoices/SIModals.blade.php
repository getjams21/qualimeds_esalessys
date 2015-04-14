<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="billSOModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title"><i id="billNo">New Invoice</i> Details
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
             <h4> SalesOrder No: <i id="billSOId"></i><br></h4>
               <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head square">Invoice No. : </span>
                  <input type="text" id="invoiceno" class="form-control" >
                </div>
              </div>
              {{ Form::label('', 'Sales Invoice Date: '); }}
                    <div class="input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$now}}" type="text" id="invoicedate"  max="{{$now}}" readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
             
          </div> 
            <div class="col-md-3"></div>
            <div class="col-md-4"><br>
              <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Customer: 
               </span>
                {{Form::select('billSOCustomers', $customers, 'key', array('class' => 'form-control square','id'=>'billSOCustomers','disabled'=>'disabled'));}}
              </div>
             </div>
             <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Customer: 
               </span>
                {{Form::select('billSOmedReps', $medReps, 'key', array('class' => 'form-control square','id'=>'billSOmedReps','disabled'=>'disabled'));}}
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
              <table class="table table-striped table-bordered table-hover BillSOTable">
                <thead>
                  <tr><th colspan="10" class="success">Invoice Details</th>
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
                  <b>Total Cost:  <i id="billSOTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
           <button type="button" class="btn btn-success hidden pull-left" id="saveBillSOBtn">Bill SO</button>
        <button type="button" class="btn btn-danger  pull-left" id="SICancelBtn">Cancel Bill</button>
           @if(isAdmin())
           <span class="alert alert-warning" id="checkAlert"> Approval status will be automatically updated upon clicking the checkbox.</span>
           <input type="checkbox" id="billApprove" style="width:18px; height:15px;"/> 
           <input type="checkbox" id="SIApproved" style="width:18px; height:15px;"/> Approved
           @endif
           &nbsp;&nbsp;
        <button type="button" class="btn btn-success hidden " id="vwSaveSIBtn">Save</button>  
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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
<!-- Print SI -->
<div class="modal fade bs-example-modal-sm " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="printSI">
  <div class="modal-dialog modal-md">
    <div  id="SIPrintable" style="margin-bottom:90px;background-color:white;margin-left:150px;" >
      <div  >
       
      </div>
      <div  >
         
            <b>
          <table style="margin-top:22px;">
            <tr><td colspan="2" style="width:130px;"></td>
                <td style="width:320px;" id="printSIName"></td>
                <td style="width:74px;"></td>
                <td style="width:115px;"></td>
                <td style="width:150px;" class="dp" id="printSIDate"></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:305px;">Address Address Address</td>
                <td style="width:74px;"></td>
                <td style="width:115px;"></td>
                <td style="width:150px;" >12345<span style="float:right;">term</span></td>
            </tr>

          </table>
        <table  id="printSITable" >
          <thead>
            <tr class="printable" style="height:25px;"> 
              <th style="width:42px;" ></th>
              <th style="width:48px;"></th>
              <th style="width:400px;"></th>
              <TH style="width:74px;"></TH>
              <th style="width:74px;"></th>
              <th style="width:150px;" ></th>
           </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
              <tr rowspan="3"></td>
                <td colspan="5" class="printheight"></td>
                <td class="dp" id="vatSales"></td>
                <td class="center" id="vatSalesDec"></td>
              </tr>
              <tr>
                <td colspan="5" class="printheight"></td>
                <td class="dp " id="vat"></td>
                <td class="center" id="vatDec"></td>
              </tr>
              <tr>
                <td colspan="5" class="printheight"></td>
                <td class="dp" id="printSITotal"></td>
                <td class="center" id="printSITotalDec"></td>
              </tr>
          </tfoot>
          </table>
           <table style="width:665px;padding-top:0;margin-top:0;" >
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583;" ><span id="printPrepBy"></span></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583;" ><span id="">test</span></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583px;"><span id="">test</span></td>
            </tr>

          </table>
         </b>
        </div><!--modal body -->
        
      </div>
  </div>
</div>