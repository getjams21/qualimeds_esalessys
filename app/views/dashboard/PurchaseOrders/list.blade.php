@extends('layouts.master')
@section('meta-title','Purchase')
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
@include('includes.PurchaseOrders.addProduct')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12 shadowed"><br>
          <!-- Nav tabs -->
            <ul class="nav nav-pills " role="tablist">
              <li class="active"><a href="#showPOEntry" role="tab" data-toggle="tab"><h5><b><i>PO Entry</i></b></h5></a></li>
              <li ><a href="#showPOList" role="tab" data-toggle="tab"><h5><b><i>PO List</i></b></h5></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="showPOEntry">
                 @include('includes.PurchaseOrders.POEntry')
              </div>
              <div class="tab-pane " id="showPOList">
                 @include('includes.PurchaseOrders.POList')  
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
        var oTable= $('.POList').dataTable( {
        	"order": [[ 0, "desc" ]],
        	"columnDefs": [
			    { "width": "8%", "targets": 6 }
			  ],
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [0] }]
    	});
          $('.product').dataTable({
             "iDisplayLength": 5,
             "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
          });

    });
</script>
@stop 