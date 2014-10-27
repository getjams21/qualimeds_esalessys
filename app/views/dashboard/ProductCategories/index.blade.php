@extends('layouts.master')
@section('meta-title','Categories')
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
       		<div class="col-md-6">
                @include('includes.ProductCategories.list')
            </div> 
            <div class="col-md-6" hidden>
                @include('includes.ProductCategories.edit')
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
<script type="text/javascript">
   $(document).ready(function() {
        var oTable= $('.category').dataTable( {
        	"order": [[ 0, "desc" ]],
    	});
    	 oTable.fnSetColumnVis( 0, false );
    });
</script>
@stop 