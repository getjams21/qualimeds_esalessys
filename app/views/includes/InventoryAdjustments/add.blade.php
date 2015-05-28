<br>
<div class="panel panel-success">
  <div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Inventory Adjustment No. {{$max+1}}</b>
      </div> 
      <div class="col-md-3" style="padding-top:6px;">
          <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
    <div class="row">
        <div class="col-md-4">
         {{ Form::open() }}
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
        </div>
       <div class="col-md-1">
       </div>
       <div class="col-md-7">
      <div class="form-group" style="width:80%;">
              <div class="input-group">
                <!-- <span class="input-group-addon">SO Type: </span>
                <select class='form-control square' name='unit' id='unit'>
                  <option value='1'>Wholesale</option>
                  <option value='2'>Retail</option>
                </select> -->
                <span class="input-group-addon">Search Product: </span>
                <input type="text" id="myInputTextField" class="form-control"  >
              </div>
       </div>
      <div class=" responsive" >
              <table class="table table-striped table-bordered table-hover product">
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
                      <td><button class="btn btn-success btn-xs square" onclick="addIA({{$product->id}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div>
      </div>
    </div>
    <div class="row">
       <div class="alert alert-danger " id="savePOError" hidden>
              <center><b>Please complete all inputs.</b></center>
            </div>
        <div class="alert alert-danger " id="invalidQty" hidden>
          <center><b>Invalid Quantity. Inputted quantity exceeded the available product count.</b></center>
        </div>
    </div>
  </div>
    <div class="panel-body">
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover IAtable">
        <thead>
          <tr>
            <th>Item #</th>
            <th>Prod. No</th>
            <th>Prod. Name</th>
            <th>Brand</th>
            <th>Lot No.</th>
            <th>Expiry Date</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Unit Price</th>
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
        <b>Total Cost:  <i id="SOTotalCost"> 0</i></b>
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
                <input type="checkbox" id="approved" style="width:15px; height:15px;"/ checked> Approved
              @endif
             </div>
            <div class="col-md-2">
              <input type="hidden" id='id' >
             <button type="button" class="btn btn-success square btn-sm hidden" id="saveSO" style="margin-right:5%;"><i class="fa fa-plus-square" ></i> <b> Save Adjustment</b></button>
             </div>
           </div>
        </div>
        @if (Session::has('flash_message'))
          <div class="form-group ">
            <p>{{Session::get('flash_message') }}</p>
          </div>
        @endif
      </div>
    </div>
    </div>

  {{ Form::close() }}
</div>