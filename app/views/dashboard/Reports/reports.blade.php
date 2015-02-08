@extends('layouts.master')
@section('meta-title','Reports')
@section('metatags')
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
       		<div class="col-md-12 ">
               Under Construction...!
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
     //    var oTable= $('.product').dataTable( {
     //    	"order": [[ 0, "desc" ]],
     //    	"columnDefs": [
			  //   { "width": "8%", "targets": 6 }
			  // ]
    	// });
    	//  oTable.fnSetColumnVis( 0, false );
    var p= $('.product').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": reroute+"/productDtAjax",
           "iDisplayLength": 3,
           "aLengthMenu": 1,
          "bLengthChange": false,
           "pagingType": "simple"
            });
       $('#myInputTextField').keyup(function(){
         p.fnFilter( $(this).val() );
        });
    });
</script>
@stop 