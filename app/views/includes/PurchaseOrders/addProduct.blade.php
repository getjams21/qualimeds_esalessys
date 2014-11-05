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
            <div class="table-responsive responsive" >
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
            </div>
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>