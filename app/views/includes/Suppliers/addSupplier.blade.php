<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="supplierModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Manage Supplier</h4>
      </div>
      <div class="modal-body">
          <div class="row">
          <div class="col-md-6 col-md-offset-3">
          <div class="well">
           {{ Form::open(array('route' => 'Suppliers.store', 'class'=>'form', 'id'=>'form'))}}
            <div class="form-group">
              {{Form::hidden('id',null,['class'=>'form-control square ','required'=>'required','id'=>'txtSupID'])}}
              {{Form::label('SupplierName', 'Supplier Name')}}
              {{Form::text('SupplierName',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('SupplierName', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('Address', 'Address')}}
              {{Form::text('Address',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('Address', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('Telephone1', 'Telephone 1')}}
              {{Form::text('Telephone1',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('Telephone1', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('Telephone2', 'Telephone 2')}}
              {{Form::text('Telephone2',null,['class'=>'form-control square','required'=>'required'])}}
              <p>{{ errors_for('Telephone2', $errors)}}</p> 
          </div>
          <div class="form-group">
              {{Form::label('ContactPerson', 'Contact Person')}}
              {{Form::text('ContactPerson',null,['class'=>'form-control square','required'=>'required'])}}
             <p>{{ errors_for('ContactPerson', $errors)}}</p> 
          </div>
          </div>
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
        {{ Form::Submit('Save Supplier',['class'=>'btn btn-success square','id'=>'btnSupplier']) }}

          {{ Form::close() }}
      </div>
    </div>
  </div>
</div>