@extends('layouts.master')
@section('meta-title','Payments')
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
@include('includes.Bills.billModals')
@include('includes.BillPayments.billPaymentModals')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 shadowed"><br>
          <!-- Nav tabs -->
            <ul class="nav nav-pills " role="tablist" id="myTab">
              <li class="active"><a href="#BillPaymentEntry" role="tab" data-toggle="tab"><h5><b><i>Bill Payment Entry</i></b></h5></a></li>
              <li ><a href="#BillPaymentList" role="tab" data-toggle="tab"><h5><b><i>Bill Payment List</i></b></h5></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="BillPaymentEntry">
                 @include('includes.BillPayments.billPaymentEntry')  
              </div>
              <div class="tab-pane " id="BillPaymentList">
                 @include('includes.BillPayments.billPaymentList')  
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
  
    // $(function() {
    //       $( "#min" ).datepicker();
    //        billPayments.fnDraw();
    //   });
    //   $(function() {
    //       $( "#max" ).datepicker('setEndDate', $( "#max" ).val());
    //        billPayments.fnDraw();
    //   });
    // $('#min').change( function() { billPayments.fnDraw(); } );
    // $('#max').change( function() { billPayments.fnDraw(); } );
    $(function() {
          $( "#chequeDueDate" ).datepicker('setStartDate', $( "#chequeDueDate" ).val());
      });
     var billTable= $('.Bills').dataTable( {
          "order": [[ 0, "desc" ]],
           "iDisplayLength": 3,
          "bLengthChange": false
     }); 
     var billPayments= $('#billPaymentsList').dataTable( {
          "order": [ 0, "desc" ]
        });
     $('#billPaymentSearch').keyup(function(){
         billPayments.fnFilter( $(this).val() );
      });
     $('#myInputTextField').keyup(function(){
         billTable.fnFilter( $(this).val() );
        });

// date search filter

});   
       
</script>

@stop 