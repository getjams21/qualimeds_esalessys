<!-- Branch Add Modal -->
<div class="modal fade" id="branch-library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Branches</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        	<div class="col-md-12">
			<div class="well customerForm">
			<div>
			{{ Form::open(['route'=>'branches.store']) }}
			<div class="form-group">
				<label>Branch Name</label>
				<input class="form-control name" type="text" name="BranchName" placeholder="Branch Name" required>
			</div>
			<div class="form-group">
				<label>Branch Address</label>
				<textarea class="form-control address" rows="3" type="textarea" name="BAddress" placeholder="Branch Address" required></textarea>
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
		<h4>Branches</h4>
	</div>
	<div class="panel-body">
		<!-- Button trigger modal -->
		<center><button class="btn btn-primary add-branch" data-toggle="modal" data-target="#branch-library">
		  New Branch
		</button></center>
		<br>
		<hr class="style-fade">	
		<div class="container-fluid">
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Branch Name</th>
                      <th>Branch Address</th>
                      <th>Telephone</th>
                      <th>Edit/Delete</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($Branches as $Branch)
                    	<tr>
                          	<td>{{$Branch->BranchName}}</td>
                          	<td>{{$Branch->BAddress}}</td>
                          	<td>{{$Branch->Telephone}}</td>
                          	<td><center><button class="btn btn-success btn-sm" onclick="triggerEditBranch({{$Branch->id}})"><span class="glyphicon glyphicon-cog"></span> Edit</button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>