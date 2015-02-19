<div class="panel panel-success">
  <div class="panel-heading head">
    <div class="row">
      <div class="col-md-12" style="padding-top:6px;">
           <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
          </div>
    </div>
    <div class="row" id="reportProducList">
      <div class="col-md-10 col-md-offset-1">
        <div class="col-md-6">
           <div class="form-group" style="width:80%;">
              <div class="input-group">
                <span class="input-group-addon">Search Product: </span>
                <input type="text" id="myInputTextField" class="form-control"  >
              </div>
          </div>
        </div><div class="col-md-6">
          <div class=" responsive well" >
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
    </div>
  </div>
    <div class="panel-body">
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover reportTable">
        <thead>
          <tr>
            <th>Branch</th>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Wholesale Unit</th>
            <th>Retail Unit</th>
            <th>Wholesale Qty</th>
            <th>Retail SaleQty</th>
          </tr>
         </thead> 
         <tbody>
            @foreach($summary as $report)
              <tr>
                <td>{{$report->BranchName}}</td>
                <td>{{$report->ProductName}}</td>
                <td>{{$report->BrandName}}</td>
                <td>{{$report->WholeSaleUnit}}</td>
                <td>{{$report->RetailUnit}}</td>
                <td class="dp">{{$report->WholeSaleQty}}</td>
                <td class="dp">{{$report->RetailSaleQty}}</td>
              </tr>
            @endforeach
         </tbody>
      </table>
    </div><hr class="style-fade">
    <hr >
    </div>

</div>