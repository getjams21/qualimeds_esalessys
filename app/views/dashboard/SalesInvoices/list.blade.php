@extends('layouts.master')
@section('meta-title','Invoice')
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
@include('includes.SalesInvoices.SIModals')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12 shadowed"><br>
          <!-- Nav tabs -->
            <ul class="nav nav-pills " role="tablist">
              <li class="active"><a href="#showSIEntry" role="tab" data-toggle="tab"><h5><b><i>SI Entry</i></b></h5></a></li>
              <li ><a href="#showSIList" role="tab" data-toggle="tab"><h5><b><i>SIList</i></b></h5></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="showSIEntry">
                 @include('includes.SalesInvoices.SIEntry')
              </div>
              <div class="tab-pane " id="showSIList">
                 @include('includes.SalesInvoices.SIList')  
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
             billTable.fnDraw();
        });
        $(function() {
            $( "#max" ).datepicker();
             billTable.fnDraw();
        });
         $(function() {
            $( "#invoicedate" ).datepicker();
        });
//PO list table 
        var billTable= $('#billListing').dataTable( {
          "order": [[ 0, "desc" ]],
          "columnDefs": [
                 { "width": "8%", "targets": 10 }
           ]
        });    
        var oTable= $('#SOList').dataTable( {
          "order": [[ 0, "desc" ]],
          "columnDefs": [
                 { "width": "8%", "targets": 7 }
           ]
        }); 
        $('#mySearchTextField').keyup(function(){
         oTable.fnFilter( $(this).val() );
        })
        $('#billSearchTextField').keyup(function(){
         billTable.fnFilter( $(this).val() );
        })
        $('#min').change( function() { billTable.fnDraw(); } );
        $('#max').change( function() { billTable.fnDraw(); } );

//date search filter
$.fn.dataTable.ext.search.push(
    function( oSettings, aData, iDataIndex ) {
      if( oSettings.nTable == document.getElementById( 'billListing' ))
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
          var arr_date = aData[2].split("/");

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