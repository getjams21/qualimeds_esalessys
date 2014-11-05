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
       		<div class="col-md-12 ">
                @include('includes.PurchaseOrders.POEntry')
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
			  ]
    	});
          $('.product').dataTable({
           
          });

    if ({{ Input::old('autoOpenModal', 'false') }}) {
        // $('#productModal').modal('show');
    }

    });
</script>
@stop 