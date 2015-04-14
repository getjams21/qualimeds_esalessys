@extends('layouts.master')
@section('meta-title','Reports')
@section('metatags')
<style type="text/css">
.dataTables_filter {
display: none; 
}
</style>
@stop
<!-- navbar -->
@section('header')
	@include('dashboard.includes.navbar')
@stop
@section('content')
<div clas="row" >
<div id="wrapper">
@include('dashboard.includes.sidebar')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12 shadowed"><br>
       		 <div class="col-md-12 shadowed"><br>
          <!-- Nav tabs -->
            <ul class="nav nav-pills " role="tablist">
              <li class="active"><a href="#showPOEntry" role="tab" data-toggle="tab"><h5><b><i>Reports</i></b></h5></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="showPOEntry">
                 @include('includes.Reports.Reportlist')
              </div>
            </div>
          </div> 

        </div>
    </div>
</div><!-- /#container-fluid -->
</div><!-- /#page-content-wrapper -->
</div> <!-- /#wrapper -->
</div>  <!-- /#row -->
@stop
<!-- footer -->
@section('footer')

@stop
@section('script')
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $(function() {
          $( "#min" ).datepicker();
      });
      $(function() {
          $( "#max" ).datepicker('setEndDate', $( "#max" ).val());
      });
    var p= $('.product').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": reroute+"/reportProductDtAjax",
           "iDisplayLength": 3,
           "aLengthMenu": 1,
          "bLengthChange": false,
           "pagingType": "simple"
            });
       $('#myInputTextField').keyup(function(){
         p.fnFilter( $(this).val() );
        });
       // p.fnSetColumnVis( 4, false );
    });
</script>
@stop 