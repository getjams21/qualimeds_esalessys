@extends('layouts.master')
@section('meta-title','UpdateAccount')
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
            <div class="col-md-8 col-md-offset-2">
                @include('includes.users.update')
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
        $('.banks').dataTable( {
        "order": [[ 3, "desc" ]]
    });
    });
</script>
@stop