@extends('layouts.master')
@section('meta-title','BillPayments')
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
  
    $(function() {
          $( "#min" ).datepicker();
           billPayments.fnDraw();
      });
      $(function() {
          $( "#max" ).datepicker('setEndDate', $( "#max" ).val());
           billPayments.fnDraw();
      });
    $('#min').change( function() { billPayments.fnDraw(); } );
    $('#max').change( function() { billPayments.fnDraw(); } );
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
$.fn.dataTable.ext.search.push(
    function( oSettings, aData, iDataIndex ) {
      if( oSettings.nTable == document.getElementById( 'billPaymentsList' ))
       {   
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1;
          var yyyy = today.getFullYear();
          
          if (dd<10)
          dd = '0'+dd;
          
          if (mm<10)
          mm = '0'+mm;
          
          today = mm+'/'+dd+'/'+yyyy;
          
          if ($('#min').val() != '' || $('#max').val() != '') {
          var iMin_temp = $('#min').val();
          if (iMin_temp == '') {
            iMin_temp = '01/01/1980';
          }
          
          var iMax_temp = $('#max').val();
          if (iMax_temp == '') {
            iMax_temp = today;
          }
          
          var arr_min = iMin_temp.split("/");
          var arr_max = iMax_temp.split("/");
          var arr_date = aData[1].split("/");

          var iMin = new Date(arr_min[2], arr_min[0], arr_min[1], 0, 0, 0, 0)
          var iMax = new Date(arr_max[2], arr_max[0], arr_max[1], 0, 0, 0, 0)
          var iDate = new Date(arr_date[2], arr_date[0], arr_date[1], 0, 0, 0, 0)
          if ( iMin == "" && iMax == "" )
          {
              return true;
          }
          else if ( iMin == "" && iDate < iMax )
          {
              return true;
          }
          else if ( iMin <= iDate && "" == iMax )
          {
              return true;
          }
          else if ( iMin <= iDate && iDate <= iMax )
          {
              return true;
          }
          return false;
          }
        }else{
          return true;
        }
    }
);
});   
       
</script>

@stop 