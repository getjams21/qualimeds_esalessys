<br>
<div class="panel panel-success">
  <div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Sales Order Entry No. {{$max+1}}</b>
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
                Customer: 
               </span>
               {{Form::select('customers', $customers, 'key', array('class' => 'form-control square','id'=>'customer'));}}
          </div><br>
           @if(Auth::user()->UserType == 1 || Auth::user()->UserType == 11)
              <div class="input-group">
                   <span class="input-group-addon panel-head square">
                    Sales Rep: 
                   </span>
                   {{Form::select('UserNo', $medReps, 'key', array('class' => 'form-control square','id'=>'medReps'));}}
              </div>
           @else
              <input type="hidden" id="medReps" value="{{Auth::user()->id}}"> 
           @endif
              <br>
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
              <center>Type the desired product on the Search Bar and click Add button to add the product to SO List.</center>
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
                      <input type="hidden" name="LotNo" id="LotNo{{$ctr}}" value="{{$product->LotNo}}">
                      <input type="hidden" name="ExpDate" id="ExpDate{{$ctr}}" value="{{$product->ExpiryDate}}">
                      <td><button class="btn btn-success btn-xs square" onclick="addSO({{$ctr}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>
                    </tr>
                    <?php $ctr++ ?>
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
    </div>
  </div>
    <div class="panel-body">
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover SOtable">
        <thead>
          <tr>
            <th>Item #</th>
            <th>Prod. Name</th>
            <th>Brand</th>
            <th>Barcode</th>
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
             <button type="button" class="btn btn-success square btn-sm hidden"  id="saveSO" style="margin-right:5%;"><i class="fa fa-plus-square" ></i> <b> Save SO</b></button>
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