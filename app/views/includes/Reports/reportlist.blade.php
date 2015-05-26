<div class="panel panel-success">
  <div class="panel-heading head">
    <div class="row">
      <div class="col-md-12" style="padding-top:6px;">
           <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
    <div class="row">
        <div class="col-md-6"><br>
          <div class="input-group">
               <span class="input-group-addon panel-head square">
                Report Type: 
               </span>
               <select id="report_type" class="form-control square">
                  <option >--Please Select--</option>
               		<option value="1">Product Inventory Summary</option>
               		<option value="2">Product Inventory By Lot Number</option>
               		<option value="3">Inventory Movement By Product / Stock Card</option>
                  <option value="4">Net Gain/Loss Report</option>
                  <option value="5">Customer Ledger</option>
               </select>
          </div><br>
          <div class="gainLossDiv" hidden>
            <div class="input-group">
                 <span class="input-group-addon panel-head square">
                  Med Rep: 
                 </span>
                 {{Form::select('UserNo', $medReps, 'key', array('class' => 'form-control square','id'=>'medReps'));}}
            </div><br>
         </div>
         <div class="customerLedgerDiv" hidden>
            <div class="input-group">
                 <span class="input-group-addon panel-head square">
                  Customer: 
                 </span>
                 {{Form::select('CustomerNo', $customers, 'key', array('class' => 'form-control square','id'=>'customers'));}}
            </div>
            <br>
         </div>
       </div>
    <div class="row  " >
      <div class="col-md-6"  >
        <div class=" gainLossDiv" hidden>

            <div class="input-group " style="margin-left:30px;">
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
            </div>
        </div>
       <div class="col-md-12 reportProducList" hidden>
          <div class=" responsive well " >

           <div class="form-group" style="width:80%;">
              <div class="input-group">
                <span class="input-group-addon">Search Product: </span>
                <input type="text" id="myInputTextField" class="form-control"  >
              </div>
          </div>
            <table class="table table-striped table-bordered table-hover product">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Product Name</th>
                  <th>Brand</th>
                  <th>Unit</th>
                  <th>Add</th>
                </tr>
               </thead> 
               <tbody>
               </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6"  >
        
      </div>
  </div>
  </div>
    <div class="panel-body">
      <div class=" responsive well " >
      <div class="productDetailDiv" hidden>
            <div class="row " >
                <div class="col-md-6">
                <b>Product No: </b><i id="reportProdNo"></i>
                </div> 
                <div class="col-md-6">
                <b>Unit Measurement: </b><i id="reportUnit"></i>
                </div> 
            </div>
          <hr>
            <div class="row">
                <div class="col-md-12">
                <b>Product Description: </b><i id="reportProdDesc"></i>
                </div> 
            </div>
         <hr>
            <div class="row">
                <div class="col-md-6">
                <b>Brand: </b><i id="reportProdBrand"></i>
                </div> 
                <div class="col-md-6">
                <b>Remaining Qty: </b><i id="reportProdQty"></i>
                </div> 
            </div>
         <hr >
        </div>
    <div class="customerLedgerDiv" hidden>
       <table style="width:100%;">
        <tr><td colspan="4" ><b>Customer Name: </b><i id="cusLedCustomerName"></i> </td></tr>
        <tr>
          <td colspan="4" ><b>Address: </b><i id="cusLedAddress"></i></td>
        </tr>
        <tr>
          <td colspan="4" ><b>Contact Person: </b><i id="cusLedContactPerson"></i></td>
        </tr>
       </table><br>
    </div>
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover reportTable" id="reportsTable">
      </table>
    </div><hr class="style-fade">
    </div>
   </div>

</div>