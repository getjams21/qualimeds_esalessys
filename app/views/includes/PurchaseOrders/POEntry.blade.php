<div class="panel panel-success">
	<div class="panel-heading head">
    <div class="row">
      <div class="col-md-9" style="padding-top:6px;">
          <b>Purchase Order Entry No. 1</b>
      </div> 
      <div class="col-md-3" style="padding-top:6px;">
          <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade"><br>
		<div class="row">
        <div class="col-md-4">
     {{ Form::open() }}
          <div class="input-group">
               <span class="input-group-addon panel-head square">
                Supplier: 
               </span>
               {{Form::select('supplier', $supplier, 'key', array('class' => 'form-control square'));}}
          </div><!-- /input-group --><br>
           <div class="input-group">
              <button type="button" class="btn btn-success  square" style="white-space: normal;" id="addProductPO" ><i class="fa fa-plus-square" ></i> <b> Add Products for PO</b></button>
          </div><!-- /input-group -->

       </div>
       <div class="col-md-4">
       </div>
       <div class="col-md-4">
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
          </div>
        </div>
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
    </div>
    </div>

  {{ Form::close() }}
</div>