<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="productModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Manage Supplier</h4>
      </div>
      <div class="modal-body">
          <div class="well">
          <div class="row">
          {{ Form::open(array('route' => 'Products.store', 'class'=>'form', 'id'=>'Productform'))}}

          <div class="col-md-6">

          
            {{Form::hidden('id',null,['class'=>'form-control square','id'=>'txtProdID'])}}
            <p>{{ errors_for('id', $errors)}}</p>
            <div class="form-group">
                {{Form::label('ProductCatNo', 'Product Category')}}
                {{  Form::select('ProductCatNo', $category, 'key', array('class' => 'form-control square'));}}
               <p>{{ errors_for('ProductCatNo', $errors)}}</p> 
             </div>
            <div class="form-group">
              {{Form::label('ProductName', 'Product Name')}}
              {{Form::text('ProductName',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('ProductName', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('BrandName', 'Brand Name')}}
              {{Form::text('BrandName',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('BrandName', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('WholeSaleUnit', 'Whole Sale Unit')}}
              {{Form::text('WholeSaleUnit',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('WholeSaleUnit', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('RetailUnit', 'Retail Unit')}}
              {{Form::text('RetailUnit',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('RetailUnit', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('RetailQtyPerWholeSaleUnit', 'Retail Qty. per Wholesale Unit')}}
              {{Form::text('RetailQtyPerWholeSaleUnit',null,['class'=>'form-control square','required'=>'required'])}}
             <p>{{ errors_for('RetailQtyPerWholeSaleUnit', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('Reorderpoint', 'Reorder Point')}}
              {{Form::text('Reorderpoint',null,['class'=>'form-control square','required'=>'required'])}}
             <p>{{ errors_for('Reorderpoint', $errors)}}</p> 
          </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                {{Form::label('Markup1', 'Markup 1')}}
                {{Form::text('Markup1',null,['class'=>'form-control square','required'=>'required'])}}
               <p>{{ errors_for('Markup1', $errors)}}</p> 
              </div>
              <div class="form-group">
                {{Form::label('Markup2', 'Markup 2')}}
                {{Form::text('Markup2',null,['class'=>'form-control square','required'=>'required'])}}
               <p>{{ errors_for('Markup2', $errors)}}</p> 
              </div>
              <div class="form-group">
                {{Form::label('Markup3', 'Markup 3')}}
                {{Form::text('Markup3',null,['class'=>'form-control square','required'=>'required'])}}
               <p>{{ errors_for('Markup3', $errors)}}</p> 
              </div>
              <div class="form-group">
                {{Form::label('ActiveMarkup', 'Active Markup')}}
                {{  Form::select('ActiveMarkup', array( 1 => 'Markup 1',2 => 'Markup 2',3 => 'Markup 3'), 'key', array('class' => 'form-control square'));}}
               <p>{{ errors_for('ActiveMarkup', $errors)}}</p> 
              </div>

          </div>
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
        {{ Form::Submit('Save Product',['class'=>'btn btn-success square']) }}

       {{ Form::close() }}
      </div>
    </div>
  </div>
</div>