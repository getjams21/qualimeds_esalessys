<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editSTModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">ST no. <i id="edSOId"></i> Details
          <b  class="pull-right" >Date: <i id="edSODate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <div class="input-group">
                      <span class="input-group-addon panel-head square">
                      Branch Source: &nbsp;&nbsp;<b>{{$branchSource->BranchName}}</b>
                      <input type="hidden" id="branchNo" value="{{Auth::user()->BranchNo}}">
                      </span>
                </div>
                <br>
                <div class="input-group">
                     <span class="input-group-addon panel-head square">
                      Branch Destination: 
                     </span>
                     {{Form::select('branches', $branches, 'key', array('class' => 'form-control square','id'=>'branch'));}}
                </div><br>
                <div class="form-group">
                <div class="input-group">
                  <div class="btn-group square" data-toggle="buttons">
                    <div class="alert alert-warning">
                    <center>Type the desired product on the Search Bar and click Add button to add the product to Transfer.</center>
                  </div>  
                 </div>
                </div><br>
                </div>
              </div>
          </div> 
            <div class="col-md-2"></div>
            <div class="col-md-6">
              
              <div class="form-group" style="width:80%;">
              <div class="input-group">
                <span class="input-group-addon">Search Product: </span>
                <input type="text" id="vwmyInputTextField" class="form-control"  >
              </div>
       </div>
      <div class=" responsive" >
              <table class="table table-striped table-bordered table-hover vwproduct">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Lot No</th>
                    <th>Expiry Date</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Add</th>
                  </tr>
                 </thead> 
                 <tbody>
                  <?php $ctr=1 ?>
                  @foreach($products as $product)
                    <tr id="rowProd{{$ctr}}">
                      <td id="prodId{{$ctr}}">{{$product->ProductNo}}</td>
                      <td id="name{{$ctr}}">{{$product->ProductName}}</td>
                      <td id="brand{{$ctr}}">{{$product->BrandName}}</td>
                      <td id="lotNo{{$ctr}}">{{$product->LotNo}}</td>
                      <td id="expiryDate{{$ctr}}">{{$product->ExpiryDate}}</td>
                      <td id="unit{{$ctr}}">{{$product->Unit}}</td>
                      <td id="unitQty{{$ctr}}">{{number_format((float)$product->Qty,0,'.','')}}</td>
                      <td id="unitPrice{{$ctr}}">{{number_format((float)$product->UnitPrice,2,'.','')}}</td>
                      <input type="hidden" name="unitQtyR" id="unitQtyR{{$ctr}}" value="{{$product->RQty}}">
                      <input type="hidden" name="ExpDate" id="ExpDate{{$ctr}}" value="{{$product->ExpiryDate}}">
                      <td><button class="btn btn-success btn-xs square" onclick="vwaddSO({{$ctr}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>
                    </tr>
                    <?php $ctr++ ?>
                  @endforeach
                 </tbody>
              </table>
              <div class="error" id="prodError" hidden> Product already exists</div>
            </div>
            </div> 
          </div>
        </div>
        </div>
          <div class="panel-body">
            <div class="table-responsive responsive" >
              <table class="table table-striped table-bordered table-hover edSOTable">
                <thead>
                  <tr>
                    <th>Item #</th>
                    <th>Prod. No.</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>LotNo</th>
                    <th>ExpiryDate</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Item Cost</th>
                    <th>Action</th>
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
                  <b>Total Cost:  <i id="edSOTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success hidden" id="vwSaveSOBtn">Save SO</button>
        <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
      </div>
    </div>
</div>
<!-- END OF VIEW PO MODAL -->

<div class="modal fade" id="successModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Success</h4>
      </div>
      <div class="modal-body panel-head" style="color:green;">
          <div class="row">
          <div class="col-md-12 ">
            <center><h4>Successfully added PO</h4></center>
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->