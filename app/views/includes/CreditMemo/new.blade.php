<!-- Bank Add Modal -->
<div class="modal fade" id="cm-library" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Credit Memo</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        	<div class="col-md-12">
			<div class="well customerForm">
			<div>
			{{ Form::open(['url'=>'/user/'.Auth::user()->id.'/storeCM']) }}
			<div class="form-group">
				<label>Customer</label>
				{{Form::select('customers', $customers, 'key', array('class' => 'form-control square','id'=>'customers'));}}
			</div>
			<div class="form-group">
				<label>Remarks</label>
				<textarea class="form-control" rows="3" type="textarea" name="remarks" id="remarks" placeholder="Remarks" required></textarea>
			</div>
			<div class="form-group">
				<label>Amount</label>
				<input type="text" class="form-control" name="amount" id="amount">
			</div>
				<input type="hidden" name="id" id="library-action" value="">
				<!-- <input type="hidden" name="id" id="cmID" value=""> -->
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
			<font size="5">Credit Memo</font>
			<button class="btn btn-success add-bank pull-right square" data-toggle="modal" data-target="#cm-library">
		  	<span class="glyphicon glyphicon-plus"></span> New Credit Memo
			</button>
		</div>
	</div>
	<div class="panel-body">
		<div class="container-fluid">
			<div class="table-responsive" >
                <table class="table table-striped table-bordered table-hover banks">
                  <thead>
                    <tr>
                      <th>Customer</th>
                      <th>Date</th>
                      <th>Remarks</th>
                      <th>Amount</th>
                      <th>Med Rep</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
              		@foreach($creditmemos as $creditmemo)
                    	<tr>
                          	<td>{{$creditmemo->CustomerName}}</td>
                          	<td>{{$creditmemo->creditmemodate}}</td>
                          	<td>{{$creditmemo->remarks}}</td>
                          	<td>{{$creditmemo->amount}}</td>
                          	<td>{{ucfirst($creditmemo->firstname).' '.ucfirst($creditmemo->lastname)}}</td>
                          	<td><center><button class="btn btn-success btn-sm" onclick="triggerEditCM({{$creditmemo->id}})"><span class="glyphicon glyphicon-cog"></span> Edit</button></center></td>
                   		</tr> 
                    @endforeach
                  </tbody>
                </table>
              </div><!--table-responsive-->
		</div>
		
	</div>
</div>