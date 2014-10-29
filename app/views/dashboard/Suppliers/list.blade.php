@extends('layouts.master')
@section('meta-title','Suppliers')
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
@include('includes.Suppliers.addSupplier')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12 shadowed"><br>
       		<div class="col-md-10 col-md-offset-1">
                @include('includes.Suppliers.supplierList')
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
        var oTable= $('.supplier').dataTable( {
        	"order": [[ 0, "desc" ]],
        	"columnDefs": [
			    { "width": "8%", "targets": 6 }
			  ]
    	});
    	 oTable.fnSetColumnVis( 0, false );

    if ({{ Input::old('autoOpenModal', 'false') }}) {
        $('#supplierModal').modal('show');
    }
    });
</script>
@stop 