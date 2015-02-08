<div class="panel panel-success">
  <div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Reports</b>
      </div> 
      <div class="col-md-3" style="padding-top:6px;">
          <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
    <div class="row">
        <div class="col-md-4">
          <div class="input-group">
               <span class="input-group-addon panel-head square">
                Report Type: 
               </span>
               <select id="report_type" class="form-control square">
               		<option value="1">Product Inventory Summary</option>
               		<option value="2">Product Inventory By Lot Number</option>
               		<option value="3">Inventory Movement By Product / Stock Card</option>
               </select>
          </div><br>
           <div class="form-group">
            <div class="input-group">
              {{Form::label('term', 'Terms :&nbsp;&nbsp;&nbsp;')}}
              <div class="btn-group square" data-toggle="buttons">
                <button class="btn btn-success square panel-head active" id="term1">
                 Cash </button>
                <button class="btn btn-success square panel-head" id="term2">
                  Term  </button>
                <div class="input-group hidden" id="termBox">
                  <input type="number" min="1" name="term" id="term" value="0" class="form-control square" style="width:80px;" required>
                  <span class="input-group-addon square">days</span>
                </div>
             </div>
             <p id="termError" class="error" hidden>Please enter a valid term days.</p>
             <p>{{ errors_for('term', $errors)}}</p> 
          </div><br>
          <div class="alert alert-warning">
              <center>Type the desired product on the Search Bar and click Add button to add the product to PO List.</center>
            </div>
        </div>
          <!-- /input-group -->
          <!--  <div class="input-group">
              <button type="button" class="btn btn-success  square" style="white-space: normal;" id="addProductPO" ><i class="fa fa-plus-square" ></i> <b> Add Products for PO</b></button>
          </div> --><!-- /input-group -->
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
    <div class="row">
       <div class="alert alert-danger " id="savePOError" hidden>
              <center><b>Please complete all inputs.</b></center>
            </div>
    </div>
  </div>
    <div class="panel-body">
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover POtable">
        <thead>
          <tr>
            <th>Item #</th>
            <th>Prod. No.</th>
            <th>Prod. Name</th>
            <th>Brand</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Unit Cost</th>
            <th>Item Cost</th>
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
        <b>Total Cost:  <i id="POTotalCost"> 0</i></b>
      </div>
    </div>
    <hr >
    <div class="row">
      <div class="col-md-12">
        <div class="well">
          <div class="row">
            <div class="col-md-7">
            <b>Prepared By: <i id="preparedBy">{{fullname(Auth::user())}}</i></b> 
            </div>
            <div class="col-md-3">
              @if(isAdmin())
            <input type="checkbox" id="approved" style="width:15px; height:15px;"/> Approved
             @endif
             </div>
            <div class="col-md-2">
             <button type="button" class="btn btn-success square btn-sm hidden"  id="savePO" style="margin-right:5%;"><i class="fa fa-plus-square" ></i> <b> Save PO</b></button>
             </div>
           </div>
        </div>
      </div>
    </div>
    </div>

</div>