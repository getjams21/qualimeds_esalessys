<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="viewPOModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">PO no. <i id="vwPOId"></i> Details
          <b  class="pull-right" >Date: <i id="vwPODate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Supplier: 
               </span>
                {{Form::select('supplier', $supplier, 'key', array('class' => 'form-control square','id'=>'vwSupplier','disabled'=>'disabled'));}}
              </div>
             </div>
              <div class="form-group">
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Terms: 
               </span>
                <input type="text" id="vwTerm" class="form-control" readonly>
              </div>
            </div>
          </div> 
            <div class="col-md-2"></div>
            <div class="col-md-5">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head">Prepared By: </span>
                  <input type="text" id="vwPreparedBy" class="form-control" readonly >
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon panel-head">Approved By: </span>
                  <input type="text" id="vwApprovedBy" class="form-control" readonly >
                </div>
              </div>
            </div> 
          </div>
        </div>
          <div class="panel-body">
            <div class="table-responsive responsive" >
              <div class="alert " id="vwCancelMsg" align="center"></div>
              <table class="table table-striped table-bordered table-hover vwPOTable">
                <thead>
                  <tr>
                    <th>Item #</th>
                    <th>Prod. No.</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Item Cost</th>
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
                  <b>Total Cost:  <i id="vwTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- END OF VIEW PO MODAL -->
<!-- VIEW PO MODAL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editPOModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">PO no. <i id="edPOId"></i> Details
          <b  class="pull-right" >Date: <i id="edPODate"></i></b>
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
                Supplier: 
               </span>
                {{Form::select('vwSupplier', $supplier, 'key', array('class' => 'form-control square','id'=>'vwSupplier'));}}
              </div>
             </div>
              <div class="form-group">
                <div class="input-group">
              {{Form::label('term', 'Terms :&nbsp;&nbsp;&nbsp;')}}
              <div class="btn-group square " data-toggle="buttons">
                <button class="btn btn-success square panel-head dis" id="edTerm1" >
                 Cash </button>
                <button class="btn btn-success square panel-head dis" id="edTerm2" >
                  Term  </button>
                <div class="input-group hidden" id="edTermBox" >
                  <input type="number" min="1" name="term" id="edTerm" class="form-control square dis" style="width:80px;" required >
                  <span class="input-group-addon square">days</span>
                </div>
             </div>
             <p id="termError" class="error" hidden> Please enter a valid term days.</p>
          </div>
            </div>
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
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th>Add</th>
                  </tr>
                 </thead> 
                 <tbody>
                  @foreach($products as $product)
                    <tr id="vwrowProd{{$product->id}}">
                      <td id="vwprodId{{$product->id}}">{{$product->id}}</td>
                      <td id="vwname{{$product->id}}">{{$product->ProductName}}</td>
                      <td id="vwbrand{{$product->id}}">{{$product->BrandName}}</td>
                      <td id="vwunit{{$product->id}}">{{$product->WholeSaleUnit}}</td>
                      <td><button class="btn btn-success btn-xs square" onclick="vwaddPO({{$product->id}})" ><i class="fa fa-check-circle"></i> Add</button>
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
              <table class="table table-striped table-bordered table-hover edPOTable">
                <thead>
                  <tr>
                    <th>Item #</th>
                    <th>Prod. No.</th>
                    <th>Product Name</th>
                    <th>Brand</th>
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
                  <b>Total Cost:  <i id="edPOTotalCost"> 0</i></b>
                </div>
              </div>
            </div>
            </div><!-- panel success-->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
           <button type="button" class="btn btn-danger  pull-left" id="POCancelBtn">Cancel PO</button>
           @if(isAdmin())
           <span class="alert alert-warning"> Approval status will be automatically updated upon clicking the checkbox.</span>
              <input type="checkbox" id="vwApproved" style="width:18px; height:15px;"/> Approved
           @endif
           &nbsp;&nbsp;
          <button type="button" class="btn btn-success hidden" id="vwSavePOBtn">Save Edit</button>
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
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