<!-- VIEW PO MODAL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editIAModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Adjustment no. <i id="edIAId"></i> Details
          <b  class="pull-right" >Date: <i id="edIADate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group">
                 <span class="input-group-addon panel-head square">
                  Branch: 
                 </span>
                 {{Form::select('branches', $branches, 'key', array('class' => 'form-control square','id'=>'branch'));}}
            </div><br>
            <div class="input-group">
                 <label>Remarks:</label>
                 {{ Form::textarea('remarks', null, ['class'=>'form-control square','size' => '50x5','id'=>'remarks', 'required']) }}
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">Prepared By: </span>
                  <input type="text" id="edPreparedBy" class="form-control" readonly >
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">Approved By: </span>
                  <input type="text" id="edApprovedBy" class="form-control" readonly >
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
                    <th>Wholesale Unit</th>
                    <th>Retail Unit</th>
                    <th>Add</th>
                  </tr>
                 </thead> 
                 <tbody>
                  @foreach($products as $product)
                    <tr id="rowProd{{$product->id}}">
                      <td id="prodId{{$product->id}}">{{$product->id}}</td>
                      <td id="name{{$product->id}}">{{$product->ProductName}}</td>
                      <td id="brand{{$product->id}}">{{$product->BrandName}}</td>
                      <td id="wholesale{{$product->id}}">{{$product->WholeSaleUnit}}</td>
                      <td id="retail{{$product->id}}">{{$product->RetailUnit}}</td>
                      <td><button class="btn btn-success btn-xs square" onclick="vwaddIA({{$product->id}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
              <div class="error" id="prodError" hidden> Product already exists</div>
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
          <button type="button" class="btn btn-success hidden" id="vwSaveSOBtn">Save Edited Adjustment</button>
        <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
      </div>
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