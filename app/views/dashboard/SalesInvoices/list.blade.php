@extends('layouts.master')
@section('meta-title','SalesInvoice')
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

<!-- <div hidden>
    <div  id="SIPrintable" style="margin-bottom:90px;background-color:white;margin-left:150px;" >
      <div  >
      </div>
      <div  >
         
          <table style="margin-top:22px;">
            <tr><td colspan="2" style="width:130px;"></td>
                <td style="width:320px;" id="printSIName"></td>
                <td style="width:74px;"></td>
                <td style="width:115px;"></td>
                <td style="width:150px;float:right;"  id="printSIDate"></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:305px;">Address Address Address</td>
                <td style="width:74px;"></td>
                <td style="width:115px;"></td>
                <td style="width:150px;" >12345<span style="float:right;">term</span></td>
            </tr>

          </table>
        <table  id="printSITable" >
          <thead>
            <tr class="printable" style="height:25px;"> 
              <th style="width:42px;" ></th>
              <th style="width:48px;"></th>
              <th style="width:400px;"></th>
              <TH style="width:74px;"></TH>
              <th style="width:74px;"></th>
              <th style="width:150px;" ></th>
           </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
              <tr rowspan="3"></td>
                <td colspan="5" class="printheight"></td>
                <td class="dp" id="vatSales"></td>
                <td class="center" id="vatSalesDec"></td>
              </tr>
              <tr>
                <td colspan="5" class="printheight"></td>
                <td class="dp " id="vat"></td>
                <td class="center" id="vatDec"></td>
              </tr>
              <tr>
                <td colspan="5" class="printheight"></td>
                <td class="dp" id="printSITotal"></td>
                <td class="center" id="printSITotalDec"></td>
              </tr>
          </tfoot>
          </table>
           <table style="width:665px;padding-top:0;margin-top:0;" >
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583;" ><span id="printPrepBy"></span></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583;" ><span id="">test</span></td>
            </tr>
            <tr><td colspan="2" style="width:82px;"></td>
                <td style="width:583px;"><span id="">test</span></td>
            </tr>

          </table>
        </div>
        
      </div>
  </div> -->
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