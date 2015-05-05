
      <div hidden>
      <div id="cashVoucherPrintable">
        <div class="panel panel-success" STYLE="margin-bottom:0px;" >
          <div class="panel-heading"><b>CASH VOUCHER</b></div>
          <div class="panel-body" STYLE="margin-bottom:0px;padding-bottom:4px;">
            <div class="col-md-12">
              <table class="table">
                <tr style="border-top:none;">
                  <td>DATE: &nbsp; &nbsp;{{date('F d, Y')}}</td>
                  <td>NO: <i id="cashVoucherNo">{{$maxCashVoucher+1}}</i></td>
                </tr>
                <tr>
                  <td colspan="2">PAY TO: Qualimeds</td>
                </tr>
                <tr>
                  <td colspan="2">ADDRESS: DAVAO CITY</td>
                </tr>
              </table>
            </div> 
          </div>
        </div><!-- panel success-->
        <div class="panel panel-success" STYLE="margin-bottom:0px;padding-bottom:4px;">
         <table class="table table-striped table-bordered table-hover" id="cashVoucherTable">
          <thead>
            <tr>
                <td colspan="7" class="success"><center><b>PARTICULARS</b></center></td>
                <td  class="success" style="width:20%;"><center><b>AMOUNT</b></center></td>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
              <td colspan="7" ><b  style="float:right;">TOTAL:</b></td>
              <td ><b style="float:right;padding-right:8%;" class="cashVoucherTotal"> </b></td>
          </tfoot>
          </table>
        </div> 
          <div class=" panel panel-success">
            <div class="panel-body"  style="padding-top:0;padding-right:0;padding-left:0;">
              <div class="col-md-3 col-sm-3 "  style="padding-top:0;padding-left:0;padding-right:0;margin-left:0;width:25%;float:left;" >
                <div class="panel panel-success" style="padding-left:0;border-bottom:none;margin-bottom:0;">
                  <div class="panel-heading"><b>CHARGE TO ACCOUNT:</b><BR></div>
                   <i id="cashVoucherCharge">&nbsp;</i><br><br>
                  <div class="panel-heading"><b>APPROVED BY:</b><BR></div>
                  <i id="cashVoucherApproved">&nbsp;@if(isAdmin(Auth::user()))
                    {{fullname(Auth::user())}}
                    @endif</i><br><br>
                </div>
              </div>
              <div class="col-md-9 col-sm-9 " style="width:75%;padding-left:0;float:left;">
                  <table class="table ">
                    <tr >
                      <td colspan="3"><b>RECEIVED from:</b> &nbsp;
                      <i id="cvReceivedFrom" ></i></td>
                    </tr ><tr >
                      <td colspan="3"><b>the amount of: </b>&nbsp;
                      <i id="wordVoucherTotal"></i> PESOS ONLY  </td>
                    </tr><tr>
                      <td style="border-top:1px solid #ddd;" colspan="2"> (<i class="cashVoucherTotal"></i> PHP)</td>
                      <td style="border-left:1px solid #ddd;" colspan="1">By:</td>
                    </tr><tr>
                      <td  style="border-top:none;" colspan="2">in full payment of the above particulars.</td>
                      <td style="border-left:1px solid #ddd;border-top:none;" colspan="1">{{fullname(Auth::user())}}</td>
                   </tr>
                  </table>
              </div><!-- col-md-9-->
          </div><!-- panel body-->
        </div><!-- panel success-->
      </div><!--printable-->
      </div><!--well -->
      
      <!-- cash voucher -->
      <!-- <div hidden>
      <div id="">
        <table>
          <tr>
            <td>{{date('F d, Y')}}</td>
            <td><i id="cashVoucherNo">{{$maxCashVoucher+1}}</i></td>
          </tr>
          <tr>
            <td colspan="2"><i id="cvReceivedFrom" ></i></td>
          </tr>
          <tr>
            <td colspan="2">Davao City</td>
          </tr>
        </table>
      </div>
      </div> -->
      <!-- end cash voucher -->
      <div hidden>
      <div id="checkVoucherPrintable">
        <div class="panel panel-success" STYLE="margin-bottom:0px;" >
          <div class="panel-heading"><b>CHECK VOUCHER</b></div>
          <div class="panel-body" STYLE="margin-bottom:0px;padding-bottom:4px;">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" >
                <tbody>
                  <tr>
                  <td ><b>Check Due Date: </b>&nbsp;&nbsp;<i id="checkVoucherDueDate"></i></td>
                  <td ><b>Check No: </b>&nbsp;&nbsp;<i id="checkVoucherCheckNo"></i></td>
                </tr>
                <tr>
                  <td colspan="2"><b>Payto: </b>&nbsp;&nbsp;<i id="checkVoucherPayTo"></i></td>
                </tr> 
                <tr>
                  <td colspan="2"><b>Bank: </b>&nbsp;&nbsp;<i id="checkVoucherBank"></i></td>
                </tr> 
                </tbody>
              </table>
              <!-- Check Details-->
              <table class="table table-striped table-bordered table-hover" id="checkVoucherTable">
                 <thead>
                  <tr>
                    <td colspan="7" class="success"><center><b>Payment Details</b></center></td>
                    <td  class="success" style="width:20%;"><center><b>AMOUNT</b></center></td>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <td colspan="7" ><b  style="float:right;">TOTAL:</b></td>
                  <td ><b style="float:right;padding-right:8%;" class="checkVoucherTotal"> </b></td>
                </tfoot>
              </table>
            </div>
            <b>Released By:____________________</b><b class="pull-right">Received By:_____________________</b><br><br>
            <b>Date:___________________________</b>
          </div><!-- panel body-->
        </div><!-- panel success-->
      </div><!--printable-->
      </div>
      <!-- </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success " id="printCashVoucher">Print</button>  
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->
<!-- END OF CHEQUE VOUCHER -->
<!-- CHEQUE -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="chequeModal">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Cheque Voucher<i id="chequeVaucherNo">{{$maxCheckVoucher+1}}</i> Details
          <b  class="pull-right" >Date:&nbsp;&nbsp;{{date('F d, Y')}}</b>
        </h4>
      </div>
      <div class="modal-body">
        <div class="well">
        <div class="panel panel-success">
          <div class="panel-heading">
             <b>Cheque No: </b><i id="chequeVoucherNo"></i>
             <i style="float:right;"> Date:<u> {{date('F d, Y')}}</u></i> 
          </div>
          <div class="panel-body">
            <div class="table-responsive responsive">
              <table class="table table-condensed">
                <tr>
                  <td colspan="1" Style="border-top:none;"> 
                   BANK: <i id="chequeVoucherBank"></i></td>
                  <td colspan="2" Style="border-top:none;"></td>
                  <td colspan="2" Style="border-top:none;"><i style="float:right;">Cheque Due Date: <u id="chequeVoucherDueDate"></u></i></td>
                </tr><tr>
                  <td colspan="1" Style="border-top:none;border-bottom:1px solid #ddd;">PAY TO THE ORDER OF: </td>
                  <td  colspan="2" Style="border-top:none;"><i id="chequeSupplier"></i></td>
                  <td Style="border-top:none;border-bottom:1px solid #ddd;">
                  <td Style="border-top:none;"><i style="float:right">&#8369; &nbsp;&nbsp;&nbsp;<u class="chequeVoucherTotal" ></u></i>
                  </td>
                </tr><tr>
                  <td  Style="border-bottom:1px solid #ddd;">
                    PESOS: </td>
                  <td colspan="4" Style="border-bottom:1px solid #ddd;" ><i id="wordchequeTotal"></i> &nbsp; PESOS ONLY
                  </td>
               </tr>
              </table>
            </div>
          </div>
      </div>
      </div><!--well -->
      </div><!--modal body -->
      <div class="modal-footer">
        
        <button type="button" class="btn btn-success " id="printCashVoucher">Print</button>  
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>