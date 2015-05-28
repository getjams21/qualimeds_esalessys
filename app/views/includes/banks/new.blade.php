<!-- Bank Add Modal -->
<div class="modal fade" id="bank-library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Banks</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        	<div class="col-md-12">
			<div class="well customerForm">
			<div>
			{{ Form::open(['url'=>'/user/'.Auth::user()->id.'/storebank']) }}
			<div class="form-group">
				<label>Bank Name</label>
				<input class="form-control name" type="text" name="BankName" placeholder="Bank Name" required>
			</div>
			<div class="form-group">
				<label>Bank Address</label>
				<textarea class="form-control address" rows="3" type="textarea" name="BAddress" placeholder="Bank Address" required></textarea>
			</div>
			<div class="form-group">
				<label>Telephone</label>
				<input class="form-control telephone" type="text" name="Telephone" id="telephone" placeholder="Telephone Number" required>
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>
			</div>
				<input type="hidden" name="id" id="library-action" value="">
			</div>
			</div>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       	<button class="btn btn-success" type="submit">Submit</button>
       	<a class="deactivate" href=""><button class="btn btn-danger delete pull-left" type="button">Deactivate</button></a>
      </div>     	
      {{ Form::close() }}
    </div>
    </div>
  </div>

@if (Session::has('flash_message'))
	<p>{{Session::get('flash_message') }}</p>
@endif

<div class="panel panel-success">
	<div class="panel-heading head">
		<div class="container-fluid">
			<font size="5">Banks</font>
			<button class="btn btn-success add-bank pull-right square" data-toggle="modal" data-target="#bank-library">
		  	<span class="glyphicon glyphicon-plus"></span> New Bank
			</button>
		</div>
	</div>
	<div class="panel-body">
		<div class="container-fluid">
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Bank Name</th>
                      <th>Bank Address</th>
                      <th>Telephone</th>
                      <th>Edit/Delete</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Banks as $Bank)
                    	<tr>
                          	<td>{{$Bank->BankName}}</td>
                          	<td>{{$Bank->BAddress}}</td>
                          	<td>{{$Bank->Telephone}}</td>
                          	<td><center><button class="btn btn-success btn-sm" onclick="triggerEdit({{$Bank->id}})"><span class="glyphicon glyphicon-cog"></span> Edit</button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>