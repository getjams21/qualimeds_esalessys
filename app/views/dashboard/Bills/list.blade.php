@extends('layouts.master')
@section('meta-title','Bills')
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
@include('includes.PurchaseOrders.addProduct')
@include('includes.Bills.billModals')
     <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
    <div class="row">
       	<div class="col-md-12 shadowed"><br>
          <!-- Nav tabs -->
            <ul class="nav nav-pills " role="tablist">
              <li class="active"><a href="#BillPOList" role="tab" data-toggle="tab"><h5><b><i>PO List for Billing</i></b></h5></a></li>
              <li ><a href="#BillsList" role="tab" data-toggle="tab"><h5><b><i>Bill List</i></b></h5></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="BillPOList">
                 @include('includes.Bills.billEntry')  
              </div>
              <div class="tab-pane " id="BillsList">
                @include('includes.Bills.billList') 
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
             oTable.fnDraw();
        });
        $(function() {
            $( "#max" ).datepicker('setEndDate', $( "#max" ).val());
             oTable.fnDraw();
        });
        $(function() {
            $( "#min2" ).datepicker();
             billTable.fnDraw();
        });
        $(function() {
            $( "#max2" ).datepicker('setEndDate', $( "#max2" ).val());
             billTable.fnDraw();
        });
         $(function() {
            $( "#invoicedate" ).datepicker();
        });
//PO list table 
        var billTable= $('#billListing').dataTable( {
          "order": [[ 0, "desc" ]],
          "columnDefs": [
                 { "width": "8%", "targets": 11 }
           ]
        });    
        var oTable= $('#POList').dataTable( {
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
        $('#min,#max').change( function() { oTable.fnDraw(); } );
        $('#min2,#max2').change( function() { billTable.fnDraw(); } );
// list of products
       var p= $('.product').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/productDtAjax",
           "iDisplayLength": 1,
           "aLengthMenu": 1,
          "bLengthChange": false,
           "pagingType": "simple"
            });
       $('#myInputTextField').keyup(function(){
         p.fnFilter( $(this).val() );
        });
       var vwp= $('.vwproduct').dataTable({
           "iDisplayLength": 1,
           "aLengthMenu": 1,
          "bLengthChange": false,
           "pagingType": "simple"
            });
       $('#vwmyInputTextField').keyup(function(){
         vwp.fnFilter( $(this).val() );
        });
//date search filter
$.fn.dataTable.ext.search.push(
    function( oSettings, aData, iDataIndex ) {
      if( oSettings.nTable == document.getElementById( 'POList' ) )
       {   
          var iFini = document.getElementById('min').value;
            var iFfin = document.getElementById('max').value;
            var iStartDateCol = 2;
            var iEndDateCol = 2;
     
            iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
            iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
     
            var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
            var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);
     
            if ( iFini === "" && iFfin === "" )
            {
                return true;
            }
            else if ( iFini <= datofini && iFfin === "")
            {
                return true;
            }
            else if ( iFfin >= datoffin && iFini === "")
            {
                return true;
            }
            else if (iFini <= datofini && iFfin >= datoffin)
            {
                return true;
            }
            return false;
        }else if( oSettings.nTable == document.getElementById( 'billListing' ) ){
            var iFini = document.getElementById('min2').value;
            var iFfin = document.getElementById('max2').value;
            var iStartDateCol = 4;
            var iEndDateCol = 4;
     
            iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
            iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
     
            var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
            var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);
     
            if ( iFini === "" && iFfin === "" )
            {
                return true;
            }
            else if ( iFini <= datofini && iFfin === "")
            {
                return true;
            }
            else if ( iFfin >= datoffin && iFini === "")
            {
                return true;
            }
            else if (iFini <= datofini && iFfin >= datoffin)
            {
                return true;
            }
            return false;
        }else{
          return true;
        }
    }
);
    });
</script>

@stop 