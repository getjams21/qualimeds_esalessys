<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addProductPOModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Add Products for PO</h4>
      </div>
      <div class="modal-body">
          <div class="well">
            <div class="alert alert-warning">
              <center>Type the desired product on the Search Bar and click Add button to add the product to PO.</center>
            </div>
          <div class="row">
            <!-- <div class="table-responsive responsive" >
              <table class="table table-striped table-bordered table-hover product">
                <thead>
                  <tr>
                    <th>Product No.</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Unit</th>
                    <th>Add</th>
                  </tr>
                 </thead> 
                 <tbody>
                  @foreach($products as $product)
                    <tr id="rowProd{{$product->id}}">
                      <td id="prodId{{$product->id}}">{{$product->id}}</td>
                      <td id="name{{$product->id}}">{{$product->ProductName}}</td>
                      <td id="brand{{$product->id}}">{{$product->BrandName}}</td>
                      <td id="unit{{$product->id}}">{{$product->WholeSaleUnit}}</td>
                      <td><button class="btn btn-success btn-xs square" onclick="addPO({{$product->id}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div> -->
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- VIEW PO MODAL -->
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="viewPOModal">
  <div class="modal-dialog modal-lg modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <input type="text" id="vwRole" value="<?php if(isAdmin()){echo 1;}else{echo 0;}?>" hidden>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">PO no. <i id="vwPOId"></i> Details
          <b  class="pull-right" >Date: <i id="vwPODate"></i></b>
        </h4>
      </div>
      <div class="modal-body">
          <div class="well">
             <!--  <div class="alert alert-warning">
                  To Edit this PO click here .. ..l..
               </div>
               <div class="alert alert-success">
                  This PO is already been approved.
               </div>  -->
          <div class="row">
          <div class="panel panel-success">
          <div class="panel-heading head">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
               <!--  <div class="input-group">
                  <span class="input-group-addon">Supplier: </span>
                  <input type="text" id="vwSupplier" class="form-control" readonly >
                </div> -->
                <div class="input-group">
               <span class="input-group-addon panel-head square">
                Supplier: 
               </span>
                {{Form::select('supplier', $supplier, 'key', array('class' => 'form-control square','id'=>'vwSupplier','disabled'=>'disabled'));}}
              </div>
             </div>
              <div class="form-group">
                <div class="input-group">
              {{Form::label('term', 'Terms :&nbsp;&nbsp;&nbsp;')}}
              <div class="btn-group square" data-toggle="buttons">
                <button class="btn btn-success square panel-head dis" id="vwTerm1" disabled>
                 Cash </button>
                <button class="btn btn-success square panel-head dis" id="vwTerm2" disabled>
                  Term  </button>
                <div class="input-group hidden" id="vwTermBox" >
                  <input type="number" min="1" name="term" id="vwTerm" class="form-control square dis" style="width:80px;" required disabled>
                  <span class="input-group-addon square">days</span>
                </div>
             </div>
             <p id="termError" class="error" hidden> Please enter a valid term days.</p>
          </div>
            </div>
          </div> 
            <div class="col-md-2"></div>
            <div class="col-md-5">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">Prepared By: </span>
                  <input type="text" id="vwPreparedBy" class="form-control" readonly >
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">Approved By: </span>
                  <input type="text" id="vwApprovedBy" class="form-control" readonly >
                </div>
              </div>
            </div> 
          </div>
        </div>
          <div class="panel-body">
            <div class="table-responsive responsive" >
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