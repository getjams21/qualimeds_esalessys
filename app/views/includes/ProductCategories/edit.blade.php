<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal-title">Edit Product Category</h4>
      </div>
      <div class="modal-body">
          <div class="row">
          <div class="col-md-8 col-md-offset-2">
           {{ Form::open()}}
           <input type="text" id="catID" hidden>
           <input type="text" id="catIndex" hidden>
            <div class="form-group">
              {{Form::label('txtCatName', 'Name')}}
              {{Form::text('txtCatName',null,['class'=>'form-control square','required'=>'required'])}}
              <span class="error hidden" id="modalCatError"></span>
            </div>
          </div>
         </div>
        </div><!--modal body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success " id="categoryBtn">Save changes</button>

          {{ Form::close() }}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->