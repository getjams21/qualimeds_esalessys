<div class="panel panel-success">
  <div class="panel-heading head" id="printable">
    <div class="row">
      <div class="col-md-12" style="padding-top:6px;">
           <b >Date:&nbsp;&nbsp;{{date('F d, Y')}} </b>
      </div> 
    </div><br>
    <hr class="style-fade">
    <div class="row">
        <div class="col-md-6"><br>
          <div class="input-group">
               <span class="input-group-addon panel-head square">
                Report Type: 
               </span>
               <select id="add_report_type" class="form-control square">
                  <option >--Please Select--</option>
               		<option value="1">Monthly Sales Report</option>
               		<option value="2">Collections Report</option>
               		<option value="3">Bad Accounts</option>
                  <option value="4">Receivables</option>
               </select>
          </div><br>
          <div class="monthlySalesDiv">
            <div class="input-group">
                 <span class="input-group-addon panel-head square" style="width:99px;">
                  Med Rep: 
                 </span>
                 {{Form::select('UserNo', $medReps, 'key', array('class' => 'form-control square','id'=>'medReps','style'=>"width:500px;"));}}
            </div><br>
         </div>
       </div>
    <div class="row  " >
      <div class="monthlySalesDiv" style="">
            <div class="input-group" style="padding-top:20px;">
              <div class="form-inline">
                    {{ Form::label('', 'From: '); }}
                    <div class="form-inline input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$onemonth}}" type="text" id="min"  readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>&nbsp;
                    {{ Form::label('', 'To: '); }}
                     <div class="form-inline input-group date txtbox-m" id="grp-from" data-date="" data-date-format="mm-dd-yyyy">
                      <input class="form-control" value="{{$now}}" type="text" id="max"  max="{{$now}}" readonly required>
                      <span class="input-group-addon calendar-icon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
              </div>
            </div>
        </div><br>
  </div>
  </div>
    <div class="panel-body">
      <div class=" responsive well " >
    <div class="table-responsive responsive" >
      <table class="table  table-bordered table-hover reportTable" id="reportsTable">
        <!-- Ajax Values for Reports -->
      </table>
      <center><button class="btn btn-primary" id="reportPrint">Print</button></center>
    </div><hr class="style-fade">
    </div>
   </div>
</div>
</div>