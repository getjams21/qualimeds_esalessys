$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    var hash = window.location.hash;
	  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
});

// to DISABLE inspect element (COMMENT OUT BEFORE INSPECT VIEWING)
window.oncontextmenu = function () {
   return false;
}
document.onkeydown = function (e) { 
    if (window.event.keyCode == 123 ||  e.button==2)    
    return false;
}

var reroute='/user/'+$('meta[name="_token"]').attr('content');
//PO FUNCTIONS
var itemno = 1;
var counter = 1;
var d = new Date();
function addPO(id){
		$.post(reroute+'/addProductToPO',{id:id},function(data){
				if($('#productId'+id).length){
					$('#prodError1').fadeIn("fast", function(){        
				        $("#prodError1").fadeOut(4000);
				    });
				}else{	
					$('.POtable').append('<tr id="PO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+id+'">'+id+'</td>
						<td>'+data['ProductName']+'</td><td>'+data['BrandName']+'</td><td>'+data['WholeSaleUnit']+'</td>
						<td class="light-green editable dp" id="prodQty'+id+'">'+money(1)+'</td><td class="light-red editable dp" id="prodUnit'+id+'">1.00</td>
						<td class="cost dp" id="prodCost'+id+'">0.00</td><td >
						<button class="btn btn-danger btn-xs square" id="removePO'+itemno+'" onclick="removePO('+itemno+')">
						<i class="fa fa-times"></i> Remove</button></td></tr>');
					itemno +=1;
						$('.editable').editable({
								send: 'never', 
							    type: 'text',
							    value:1,
							    validate: function(value) {
							        if($.trim(value) == '') {
							         return 'This field is required';
							        }
							        if ($.isNumeric(value) == '' || value==0) {
							            return 'Please input a valid number greater than 0';
							        }
							    },
							    emptytext:0,
							   display: function(value) {
							   		$(this).text(money(value));
							        calcCost(id);
									}
							});
						$('#savePO').removeClass('hidden');
					}
			});	
}
function calcCost(id){
	var qty = $('#prodQty'+id).text();
	var unit = $('#prodUnit'+id).text();
	$('#prodCost'+id).text(money(qty*unit));
	totalCost();
}
function totalCost(){
	var total=0;
	$('.cost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#POTotalCost').text(money(total));
	if(total = 0){
		$('#savePO').addClass('hidden');
	}
}
function removePO(id){
	$('#PO'+id).remove();
	id +=1;
	if( $('#PO'+id).length ) 
	{
	  while(id<itemno){
			$('#PO'+id).attr('id','PO'+(id-1));
			$('#itemno'+(id)).attr('id','itemno'+(id-1));
			$('#itemno'+(id-1)).text(id-1);
			$('#removePO'+(id)).attr('id','removePO'+(id-1));
			$('#removePO'+(id-1)).attr('onclick','removePO('+(id-1)+')');
			id++;
		}
	}
	itemno -=1;
	totalCost();
}
function viewPO(id){
	$('#viewPOModal').modal('show');
	$.post(reroute+'/viewPO',{id:id},function(data){
	 	$('#vwPOId').text(data[0]['id']);
	 	$('#vwPODate').text(data[0]['PODate']);
	 	$('#vwSupplier').val(data[0]['SupplierNo']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#vwTerm').val('Cash');
		}else{
		 	$('#vwTerm').val(data[0]['Terms']);
		}
	 	$('#vwPreparedBy').val(data[0]['PreparedBy']);
	 	if(data[0]['ApprovedBy'] == ''){
	 		$('#vwApprovedBy').val('N/A');
	 	}else{
	 		$('#vwApprovedBy').val(data[0]['ApprovedBy']);
	 	}
	 	$('#vwCancelMsg').attr('class','alert');
	 	if(data[0]['IsCancelled'] == 1){
	 		$('#vwCancelMsg').addClass('alert-danger');
	     	$('#vwCancelMsg').text('This PO has been cancelled by '+data[0]['CancelledBy']);
	 	}else if(data[0]['ApprovedBy'] != ''){
	 		$('#vwCancelMsg').addClass('alert-success');
	     	$('#vwCancelMsg').text('This PO has been approved by '+data[0]['ApprovedBy']);
	 	}
	});
	$.post(reroute+'/viewPODetails',{id:id},function(data){
	  			$(".vwPOTable > tbody").html("");
	  			    counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.vwPOTable >tbody').append('<tr ><td>'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td >'+value.Unit+'</td><td class="dp">'+Number(value.Qty).toFixed(0) +'</td><td class="dp">'+Number(value.CostPerQty).toFixed(2)+'</td>
	  					<td class="dp">'+(value.CostPerQty*value.Qty)+'</td></tr>');
		  			counter+=1;
		  			total+=value.CostPerQty*value.Qty;
	  				});
	  				$('#vwTotalCost').text(Number(total).toFixed(2));
	      });
}
function editPO(id){
	$('#vwSavePOBtn').addClass('hidden');
	$('#editPOModal').modal('show');
	 $.post(reroute+'/viewPO',{id:id},function(data){
	 	$('#edPOId').text(data[0]['id']);
	 	$('#edPODate').text(data[0]['PODate']);
	 	$('[name="vwSupplier"]').val(data[0]['SupplierNo']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#edTerm').val(0);
	 		$('#edTerm1').addClass('active');
	 		$('#edTerm2').removeClass('active');
	 		$('#edTermBox').addClass('hidden');
		}else{
		 	$('#edTerm').val(data[0]['Terms']);
		 	$('#edTerm1').removeClass('active');
		 	$('#edTerm2').addClass('active');
		 	$('#edTerm2').prop("disabled", false);
		 	$('#edTermBox').removeClass('hidden');
		}
	 	$('#edPreparedBy').val(data[0]['PreparedBy']);
	 	if(data[0]['ApprovedBy'] == ''){
	 		$('#edApprovedBy').val('N/A');
	 		$('#vwApproved').prop('checked', false);
	 	}else{
	 		$('#edApprovedBy').val(data[0]['ApprovedBy']);
	 		$('#vwApproved').prop('checked', true);
	 		if(document.title == 'Bills'){
	 			$('#vwApproved').prop('disabled',true);
	 		}
	 	}
	      });
	 $.post(reroute+'/viewPODetails',{id:id},function(data){
	  			$(".edPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+value.ProductNo+'">'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="vweditable dp" id="edQty'+value.ProductNo+'">'+value.Qty+'</td><td class="vweditable dp" id="edUnit'+value.ProductNo+'">'+Number(value.CostPerQty).toFixed(2)+'</td>
	  					<td class="ecost dp"id="edCost'+value.ProductNo+'">'+Number(value.CostPerQty).toFixed(2)+'</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
		  			total+=value.CostPerQty*value.Qty;
	  				editable(value.ProductNo);
		  			counter+=1;
	  				});
	  				$('#edPOTotalCost').text(Number(total).toFixed(2));
	      });
}
function billPO(id){
	$('#saveBillPOBtn,#billApprove').removeClass('hidden');
	$('#vwSaveBillBtn,#BillCancelBtn,#checkAlert,#billApproved').addClass('hidden');
	$('#billNo').text('New Bill');
	$('#billPOModal').modal('show');
	 $.post(reroute+'/viewPO',{id:id},function(data){
	 	$('#billPOId').text(data[0]['id']);
	 	$('[name="billPOSupplier"]').val(data[0]['SupplierNo']);
	 	$('#billBranchName').val(data[0]['BranchName']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#billTerm').val(0);
	 		$('#billTerm1').addClass('active');
	 		$('#billTerm2').removeClass('active');
	 		$('#billTermBox').addClass('hidden');
		}else{
		 	$('#billTerm').val(data[0]['Terms']);
		 	$('#billTerm1').removeClass('active');
		 	$('#billTerm2').addClass('active');
		 	$('#billTerm2').prop("disabled", false)
		 	$('#billTermBox').removeClass('hidden');
		}
	      });
	 $.post(reroute+'/viewPODetails',{id:id},function(data){
	  			$(".BillPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable >tbody').append('<tr id="billPO'+counter+'" class="billRow"><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="numberEditable danger"></td><td class="danger dateEditable">'+(d.getFullYear()+1)+'-01-01</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.CostPerQty).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.CostPerQty*value.Qty).toFixed(2)+'</td><td class="vweditable dp danger">0</td><td class="danger selectEditable dp"></td></tr>');
		  			total+=value.CostPerQty*value.Qty;
	  				editable(value.ProductNo);
	  				editableNumber(value.ProductNo);
	  				editableSelect(value.ProductNo,value.RetailUnit,value.WholeSaleUnit);
		  			dateEditable(value.ProductNo);
		  			counter+=1;
	  				});
	  				$('#billPOTotalCost').text(Number(total).toFixed(2));
	      });
}
function editBill(id){
	$('#saveBillPOBtn,#vwSaveBillBtn,#billApprove').addClass('hidden');
	$('#BillCancelBtn,#checkAlert,#billApproved,#vwSaveBillBtn').removeClass('hidden');
	$('#vwSaveBillBtn').val(id);
	$('#billPOModal').modal('show');
	$('#billNo').text('Bill No. '+id);
	$.post(reroute+'/viewBill',{id:id},function(data){
		$('#billPOId').text(data[0]['PurchaseOrderNo']);
	 	$('[name="billPOSupplier"]').val(data[0]['SupplierNo']);
	 	$('#billBranchName').val(data[0]['BranchName']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#billTerm').val(0);
	 		$('#billTerm1').addClass('active');
	 		$('#billTerm2').removeClass('active');
	 		$('#billTermBox').addClass('hidden');
		}else{
		 	$('#billTerm').val(data[0]['Terms']);
		 	$('#billTerm1').removeClass('active');
		 	$('#billTerm2').addClass('active');
		 	$('#billTerm2').prop("disabled", false)
		 	$('#billTermBox').removeClass('hidden');
		}
		if(data[0]['ApprovedBy'] == ''){
	 		$('#billApproved').prop('checked', false);
	 	}else{
	 		$('#billApproved').prop('checked', true);
	 	}
		var InvDate = new Date(data[0]['SalesInvoiceDate']);
		$('#invoicedate').val((InvDate.getMonth() + 1) + '/' + InvDate.getDate() + '/' +  InvDate.getFullYear());
		$('#invoiceno').val(data[0]['SalesInvoiceNo']);
	});
	$.post(reroute+'/viewBillDetails',{id:id},function(data){
	  			$(".BillPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable >tbody').append('<tr id="billPO'+counter+'" ><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="numberEditable danger">'+value.LotNo+'</td><td class="danger dateEditable">'+value.ExpiryDate+'</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.Cost).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.Cost*value.Qty).toFixed(2)+'</td><td class="vweditable dp danger">'+value.FreebiesQty+'</td><td class="danger selectEditable dp">'+value.FreebiesUnit+'</td></tr>');
		  			total+=value.Cost*value.Qty;
	  				editable(value.ProductNo);
	  				editableNumber(value.ProductNo);
	  				editableSelect(value.ProductNo,value.RetailUnit,value.WholeSaleUnit);
		  			dateEditable(value.ProductNo);
		  			counter+=1;
	  				});
	  				$('#billPOTotalCost').text(Number(total).toFixed(2));
	      });
}
function viewBill(id){
	$('#viewBillModal').modal('show');
	$('#vwbillNo').text(id);
	$.post(reroute+'/viewBill',{id:id},function(data){


		
		$('#vwbillPOId').text(data[0]['PurchaseOrderNo']);
	 	$('[name="vwBillSupplier"]').val(data[0]['SupplierNo']);
	 	$('#vwBillBranchName').val(data[0]['BranchName']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#vwBillTerm').val('Cash');
		}else{
		 	$('#vwBillTerm').val(data[0]['Terms']);
		}
	 $('#billDate').text(data[0]['BillDate']);
		var InvDate = new Date(data[0]['SalesInvoiceDate']);
		$('#vwBillInvoiceDate').val((InvDate.getMonth() + 1) + '/' + InvDate.getDate() + '/' +  InvDate.getFullYear());
		$('#vwBillInvoiceNo').val(data[0]['SalesInvoiceNo']);
	});
	$.post(reroute+'/viewBillDetails',{id:id},function(data){
	  			$(".BillPOTable2 > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable2 >tbody').append('<tr ><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td >'+value.LotNo+'</td><td >'+value.ExpiryDate+'</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.Cost).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.Cost*value.Qty).toFixed(2)+'</td><td class="dp ">'+value.FreebiesQty+'</td><td class="dp">'+value.FreebiesUnit+'</td></tr>');
		  			total+=value.Cost*value.Qty;
		  			counter+=1;
	  				});
	  				$('#vwBillTotalCost').text(Number(total).toFixed(2));
	      });
}
// SO BILLING FUNCTION
function billSO(id){
	$('#saveBillSOBtn,#billApprove').removeClass('hidden');
	$('#vwSaveBillBtn,#SICancelBtn,#checkAlert,#SIApproved').addClass('hidden');
	$('#billNo').text('New Invoice');
	$('#billSOModal').modal('show');
	 $.post(reroute+'/viewSO',{id:id},function(data){
	 	$('#billSOId').text(data[0]['id']);
	 	$('[name="billSOCustomers"]').val(data[0]['CustomerNo']);
	 	$('[name="billSOmedReps"]').val(data[0]['UserNo']);
	 	$('#printSICusAddress').text(data[0]['Address']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#billTerm').val(0);
	 		$('#billTerm1').addClass('active');
	 		$('#billTerm2').removeClass('active');
	 		$('#billTermBox').addClass('hidden');
	 		$('#printSITerm').text('Cash');
	 		
		}else{
		 	$('#billTerm').val(data[0]['Terms']);
		 	$('#billTerm1').removeClass('active');
		 	$('#billTerm2').addClass('active');
		 	$('#billTerm2').prop("disabled", false)
		 	$('#billTermBox').removeClass('hidden');
		 	$('#printSITerm').text(data[0]['Terms']);
		}
	      });
	 $.post(reroute+'/viewSODetails',{id:id},function(data){
	  			$(".BillSOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillSOTable >tbody').append('<tr id="billSO'+counter+'" class="billRow"><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td >'+value.LotNo+'</td><td >'+value.ExpiryDate+'-01-01</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.UnitPrice).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.UnitPrice*value.Qty).toFixed(2)+'</td><td class="numberEditable dp danger">0</td><td class="danger selectEditable dp"></td></tr>');
		  			total+=value.UnitPrice*value.Qty;
	  				editableNumber(value.ProductNo);
	  				editableSelect(value.ProductNo,value.RetailUnit,value.WholeSaleUnit);
	  				// var exp = new Date(value.ExpiryDate);
	  				// var expDate = (exp.getMonth() + 1) + '-' + exp.getDate() + '-' +  exp.getFullYear();
	  				// alert( value.ExpiryDate);
	  				var str = value.ExpiryDate;
	  				str = str.replace(/-/g,"/");
					var dateObject = new Date(str);
					var expDate = (dateObject.getMonth() + 1) + '-' + dateObject.getDate() + '-' +  dateObject.getFullYear();
	  				var num=(value.UnitPrice*value.Qty);
					var str=num.toString();
					var numarray=str.split('.');
					if(!numarray[1]){
						numarray[1] = '00';
					}
	  				$('#printSITable >tbody').append('<tr style="height:27px;"><td >'+Number(value.Qty).toFixed(0)+'</td><td>'+value.Unit+'</td>
	  					<td style="max-width:385px;overflow:hidden; text-overflow: ellipsis;white-space: nowrap;">'+value.ProductName+'</td>
	  					<td>'+expDate+'</td><td class="dp">'+Number(value.UnitPrice).toFixed(2)+'</td><td class="dp" style="width: 90px;">'+numberWithCommas((num).toFixed(2))+'</td></tr>');
		  			
		  			counter+=1;
	  				});

		  			var rows = document.getElementById('printSITable').getElementsByTagName("tr").length;
	  				while(rows <= 15){
	  					$('#printSITable >tbody').append('<tr style="height:27px;"><td ></td><td></td>
	  					<td></td>
	  					<td></td><td class="dp"></td><td></td><td ></td></tr>');
		  				rows ++;
	  				}
					// var total = Number(total).toFixed(2);
					var prep = $("[name='billSOmedReps'] option:selected").text();
					var cust = $("[name='billSOCustomers'] option:selected").text();
	  				$('#billSOTotalCost').text(total);
	  				var vatsales = total/1.12;
	  				var vat = vatsales *.12;
	  				$('#vatSales').text(numberWithCommas(vatsales.toFixed(2)));
	  				$('#vat').text(numberWithCommas(vat.toFixed(2)));
	  				$('#printSITotal').text(numberWithCommas(total.toFixed(2)));
	  				// $('#printPrepBy').text(prep);
	  				$('#printSIName').text(cust);
	  				var today = new Date();
	  				var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
	  				if(dd<10) {
					    dd='0'+dd
					} 

					if(mm<10) {
					    mm='0'+mm
					} 
					$('#printSIDate').text(mm+'-'+dd+'-'+yyyy);
	  				
	      });
}
// print SI function
function printSI(id,prep,app){
	
	$('#printPrepBy').text(prep);
	$('#printApprovedBy').text(app);
	$('#printSITable tbody tr').remove();
	$.post(reroute+'/viewSO',{id:id}).done(function(d){
	 	$('#printSICusAddress').text(d[0]['Address']);
	 	if(d[0]['Terms'] == '0'){
	 		$('#printSITerm').text('Cash');
	 		
		}else{
		 	$('#printSITerm').text(d[0]['Terms']);
		}
			 $.post(reroute+'/viewSODetails',{id:id}).done(function(data){
			  			counter=1;
			  			var total=0;
					  		$.each(data, function(key,value) {
			  				total+=value.UnitPrice*value.Qty;
			  				var str = value.ExpiryDate;
			  				str = str.replace(/-/g,"/");
							var dateObject = new Date(str);
							var expDate = (dateObject.getMonth() + 1) + '-' + dateObject.getDate() + '-' +  dateObject.getFullYear();
			  				var num=(value.UnitPrice*value.Qty);
							var str=num.toString();
							var numarray=str.split('.');
							if(!numarray[1]){
								numarray[1] = '00';
							}
			  				$('#printSITable >tbody').append('<tr style="height:27px;"><td >'+Number(value.Qty).toFixed(0)+'</td><td>'+value.Unit+'</td>
			  					<td style="max-width:385px;overflow:hidden; text-overflow: ellipsis;white-space: nowrap;">'+value.ProductName+'</td>
			  					<td>'+expDate+'</td><td class="dp">'+Number(value.UnitPrice).toFixed(2)+'</td><td class="dp" style="width: 90px;">'+numberWithCommas((num).toFixed(2))+'</td></tr>');
				  			
				  			counter+=1;
			  				});

				  			var rows = document.getElementById('printSITable').getElementsByTagName("tr").length;
			  				while(rows <= 15){
			  					$('#printSITable >tbody').append('<tr style="height:27px;"><td ></td><td></td>
			  					<td></td>
			  					<td></td><td class="dp"></td><td></td><td ></td></tr>');
				  				rows ++;
			  				}
							// var total = Number(total).toFixed(2);
							var prep = $("[name='billSOmedReps'] option:selected").text();
							var cust = $("[name='billSOCustomers'] option:selected").text();
			  				$('#billSOTotalCost').text(total);
			  				var vatsales = total/1.12;
			  				var vat = vatsales *.12;
			  				$('#vatSales').text(numberWithCommas(vatsales.toFixed(2)));
			  				$('#vat').text(numberWithCommas(vat.toFixed(2)));
			  				$('#printSITotal').text(numberWithCommas(total.toFixed(2)));
			  				// $('#printPrepBy').text(prep);
			  				$('#printSIName').text(cust);
			  				var today = new Date();
			  				var dd = today.getDate();
							var mm = today.getMonth()+1; //January is 0!
							var yyyy = today.getFullYear();
			  				if(dd<10) {
							    dd='0'+dd
							} 

							if(mm<10) {
							    mm='0'+mm
							} 
							$('#printSIDate').text(mm+'-'+dd+'-'+yyyy);
			  			var printable = $("#SIPrintable").html();
						$(printable).printThis({
								     debug: false,             
								     importCSS: false,           
								     printContainer: true,       
								     pageTitle: "Sales Invoice",              
								     removeInline: false,        
								     printDelay: 333,           
								     header: null,              
								     formValues: true,
								     page:'A3',
								     margins:'none'           
								  });
						return;		

			});
					  
	      });
			
			
			
}
// function printNow(){

// 				$("#SIPrintable").printThis({
// 					     debug: false,             
// 					     importCSS: false,           
// 					     printContainer: true,       
// 					     pageTitle: "Sales Invoice",              
// 					     removeInline: false,        
// 					     printDelay: 333,           
// 					     header: null,              
// 					     formValues: true,
// 					     page:'A3',
// 					     margins:'none'           
// 					  });
// }
function displayDate(date){
	var today = new Date();
	  				var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
	  				if(dd<10) {
					    dd='0'+dd
					} 

					if(mm<10) {
					    mm='0'+mm
					} 
    return mm+'-'+dd+'-'+yyyy;		
}
function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

// END OF SO BILLING FUNCTION
// SI EDITING FUNCTIONS
function editSI(id){
$('#saveBillSOBtn,#vwSaveBillBtn,#billApprove').addClass('hidden');
$('#SICancelBtn,#checkAlert,#SIApproved,#vwSaveSIBtn').removeClass('hidden');
$('#vwSaveSIBtn').val(id);
$('#billSOModal').modal('show');
$('#billNo').text('Invoice No. '+id);
	$.post(reroute+'/viewSI',{id:id},function(data){
		$('#billSOId').text(data['SalesOrderNo']);
	 	$('[name="billSOCustomers"]').val(data['CustomerNo']);
	 	$('[name="billSOmedReps"]').val(data['UserNo']);
	 	if(data['Terms'] == '0'){
	 		$('#billTerm').val(0);
	 		$('#billTerm1').addClass('active');
	 		$('#billTerm2').removeClass('active');
	 		$('#billTermBox').addClass('hidden');
		}else{
		 	$('#billTerm').val(data['Terms']);
		 	$('#billTerm1').removeClass('active');
		 	$('#billTerm2').addClass('active');
		 	$('#billTerm2').prop("disabled", false)
		 	$('#billTermBox').removeClass('hidden');
		}
		if(data['ApprovedBy'] == ''){
	 		$('#SIApproved').prop('checked', false);
	 	}else{
	 		$('#SIApproved').prop('checked', true);
	 	}
		var InvDate = new Date(data['InvoiceDate']);
		$('#invoicedate').val((InvDate.getMonth() + 1) + '/' + InvDate.getDate() + '/' +  InvDate.getFullYear());
		$('#invoiceno').val(data['SalesInvoiceRefDocNo']);
	});
	$.post(reroute+'/viewSIDetails',{id:id},function(data){
  			$(".BillSOTable > tbody").html("");
  			counter=1;
  			var total=0;
		  		$.each(data, function(key,value) {
	  				$('.BillSOTable >tbody').append('<tr id="billSO'+counter+'" class="billRow"><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td >'+value.LotNo+'</td><td >'+value.ExpiryDate+'-01-01</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.UnitPrice).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.UnitPrice*value.Qty).toFixed(2)+'</td><td class="numberEditable dp danger">'+value.FreebiesQty+'</td><td class="danger selectEditable dp">'+value.FreebiesUnit+'</td></tr>');
		  			total+=value.UnitPrice*value.Qty;
	  				editableNumber(value.ProductNo);
	  				if(value.FreebiesUnit == value.RetailUnit){
	  					editableSelect(value.ProductNo,value.RetailUnit,value.WholeSaleUnit);
	  				}else if(value.FreebiesUnit == value.WholeSaleUnit){
	  					editableSelect(value.ProductNo,value.WholeSaleUnit,value.RetailUnit);
	  				}
		  			counter+=1;
	  				});
	  				$('#billSOTotalCost').text(Number(total).toFixed(2));
      });
}
// END OF SI EDITING FUNCTIONS
// SI VIEWING FUNCTION
function viewSI(id){
	$('#viewSIModal').modal('show');
	$('#vwbillNo').text(id);
	$.post(reroute+'/viewSI',{id:id},function(data){
		$('#vwbillSOId').text(data['SalesOrderNo']);
	 	$('[name="vwbillSOCustomers"]').val(data['CustomerNo']);
	 	$('[name="vwbillSOmedReps"]').val(data['UserNo']);
	 	if(data['Terms'] == '0'){
	 		$('#vwBillTerm').val('Cash');
		}else{
		 	$('#vwBillTerm').val(data['Terms']);
		}
	 	$('#billDate').text(data['created_at']);
		var InvDate = new Date(data['InvoiceDate']);
		$('#vwBillInvoiceDate').val((InvDate.getMonth() + 1) + '/' + InvDate.getDate() + '/' +  InvDate.getFullYear());
		$('#vwBillInvoiceNo').val(data['SalesInvoiceRefDocNo']);
	});
	$.post(reroute+'/viewSIDetails',{id:id},function(data){
	  			$(".BillSOTable2 > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillSOTable2 >tbody').append('<tr id="billSO'+counter+'" class="billRow"><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td >'+value.LotNo+'</td><td >'+value.ExpiryDate+'-01-01</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.UnitPrice).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.UnitPrice*value.Qty).toFixed(2)+'</td><td class="numberEditable dp danger">'+value.FreebiesQty+'</td><td class="danger selectEditable dp">'+value.FreebiesUnit+'</td></tr>');
		  			total+=value.UnitPrice*value.Qty;
		  			counter+=1;
	  				});
	  				$('#vwBillTotalCost').text(Number(total).toFixed(2));
	      });
}
// END OF SI VIEWING FUNCTION
function editable(id){
	$('.vweditable').editable({
			send: 'never', 
		    type: 'text',
		    validate: function(value) {
		        if($.trim(value) == '') {
		         return 'This field is required';
		        }
		        else if($.isNumeric(value) == '' || value==0) {
		            return 'Please input a valid number greater than 0';
		        }
		    },
		    emptytext:0,
		   display: function(value) {
		   		$(this).text(Number(value).toFixed(2));
		        edcalcCost(id);
				}
	});
}
function editableNumber(id){
	$('.numberEditable').editable({
			send: 'never', 
		    type: 'text',
		     emptytext:0,
		    validate: function(value) {
		        if($.trim(value) == '') {
		         return 'This field is required';
		        }
		        else if($.isNumeric(value) == '' || value==0) {
		            return 'Please input a valid number greater than 0';
		        }
		    },
		   display: function(value) {
		   		$(this).text(value);
				}
	});
}
function editableSelect(id,first,second){
	$('.selectEditable').editable({
        value: 1, 
        type: 'select',
	    validate: function(value) {
	        if($.trim(value) == '') {
	         return 'This field is required';
	        }
	    },   
        source: [
              {value: 1, text: first},
              {value: 2, text: second}
           ]
    });	
}
function dateEditable(id){
	$('.dateEditable').editable({
		type: 'combodate',
        format: 'YYYY-MM-DD',    
        viewformat: 'YYYY-MM-DD',    
        template: 'D / MMMM / YYYY',
	    validate: function(value) {
	        if($.trim(value) == '') {
	         return 'This field is required';
	        }
	    },    
        combodate: {
                minYear: d.getFullYear(),
                maxYear: d.getFullYear()+10,
                minuteStep: 1
           }
    });
}

function edcalcCost(id){
	var qty = $('#edQty'+id).text();
	var unit = $('#edUnit'+id).text();
	$('#edCost'+id).text(Number(qty*unit).toFixed(2));
	edtotalCost();
}
function edtotalCost(){
	var total=0;
	$('.ecost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#edPOTotalCost').text(Number(total).toFixed(2));
	if(total == 0){
		$('#vwSavePOBtn').addClass('hidden');
	}
}
function vwaddPO(id){
	var name= $('#vwname'+id).text();
	var brand= $('#vwbrand'+id).text();
	var unit= $('#vwunit'+id).text();
	var table = $('.vwproduct').DataTable();
	var index=table.row('#vwrowProd'+id).index();
	if($('#vwProd'+id).length){
		 $('#prodError').fadeIn("fast", function(){        
	        $("#prodError").fadeOut(4000);
	    });
	}else{
	$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+id+'">'+id+'</td>
	  					<td>'+name+'</td>
	  					<td>'+brand+'</td><td>'+unit+'</td><td class="vweditable dp" id="edQty'+id+'">'+Number(1).toFixed(2)+'</td><td class="vweditable dp" id="edUnit'+id+'">'+Number(1).toFixed(2)+'</td>
	  					<td class="ecost dp"id="edCost'+id+'">0.00</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
	
		counter +=1;
		editable(id);
		$('#vwSavePOBtn').removeClass('hidden');
	}
}
function vwRemovePO(id){
	$('#vwPO'+id).remove();
	id +=1;
	if( $('#vwPO'+id).length ) 
	{
	  while($('#vwPO'+id).length ){
			$('#vwPO'+id).attr('id','vwPO'+(id-1));
			$('#vwItemno'+(id)).attr('id','vwItemno'+(id-1));
			$('#vwItemno'+(id-1)).text(id-1);
			$('#vwRemovePO'+(id)).attr('id','vwRemovePO'+(id-1));
			$('#vwRemovePO'+(id-1)).attr('onclick','vwRemovePO('+(id-1)+')');
			id++;
		}
	}
	counter -=1;
	edtotalCost();
	$('#vwSavePOBtn').removeClass('hidden');
}
// END OF PO FUNCTIONS
//edit-delte bank
function triggerEdit(id){
	$.post(reroute+'/toEditBank',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
	  			$('#library-action').val(data['id']);
	  			$('.name').val(data['BankName']);
	  			$('.address').val(data['BAddress']);
	  			$('.telephone').val(data['Telephone']);
	  			$('.deactivate').attr('href', '/delete-bank/'+id+'');
	  			$('.delete').show();
  		}
  	});
$('#bank-library').modal('show');
}
//edit-delete credit memo
function triggerEditCM(id){
	$.post(reroute+'/toEditCM',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
	  		$('#library-action').val(data['id']);
	      	$('#customers').val(data['customerno']);
	      	$('#medReps').val(data['userno']);
	      	$('#remarks').val(data['remarks']);
	      	$('#amount').val(data['amount']);
	      	$('.deactivate').attr('href', '/delete-cm/'+id+'');
  			$('.delete').show();
  		}
  	});
$('#cm-library').modal('show');
}
//edit-delete branch
function triggerEditBranch(id){
	$.post(reroute+'/toEditBranch',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
	  			$('#library-action').val(data['id']);
	  			$('.name').val(data['BranchName']);
	  			$('.address').val(data['BAddress']);
	  			$('.telephone').val(data['Telephone']);
	  			$('.deactivate').attr('href', '/delete-branch/'+id+'');
	  			$('.delete').show();
  		}
  	});
$('#branch-library').modal('show');
}
//edit-delete branch
function triggerEditCustomer(id){
	$.post(reroute+'/toEditCustomer',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
	  			$('#library-action').val(data['id']);
	  			$('.name').val(data['CustomerName']);
	  			$('.address').val(data['Address']);
	  			$('.telephone1').val(data['Telephone1']);
	  			$('.telephone2').val(data['Telephone2']);
	  			$('.contact-person').val(data['ContactPerson']);
	  			$('.credit-limit').val(data['CreditLimit']);
	  			$('.deactivate').attr('href', '/delete-customer/'+id+'');
	  			$('.delete').show();
  		}
  	});
 $('#customer-library').modal('show');
 }
function triggerEditUser(id){
	$.post(reroute+'/toEditUser',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  				//user type select
  				$('select#usertype option[value="'+data['UserType']+'"]').attr('selected',true);
  				//branch select
  				$('select#branches option[value="'+data['BranchNo']+'"]').attr('selected',true);
	  			$('#library-action').val(data['id']);
	  			$('.username').val(data['username']);
	  			$('.lastname').val(data['Lastname']);
	  			$('.firstname').val(data['Firstname']);
	  			$('.mi').val(data['MI']);
	  			$('.usertype').val(data['UserType']);
	  			$('.deactivate').attr('href', '/delete-user/'+id+'');
	  			$('.delete').show();
  		}
  	});
$('.user-pwd').hide();
$('.password,.retype-password').removeAttr('required');
$('#user-library').modal('show');
}
function money(x){
	return Number(x).toFixed(2);
}
function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
//BILLPAYMENTS
function addBillToPayment(id){
	$.post(reroute+'/addBillToPayment',{id:id},function(data){
				if($('#billId'+id).length){
					$('#billError1').fadeIn("fast", function(){        
				        $("#billError1").fadeOut(4000);
				    });
				}else{	
					if($('#bill1').length){
						if(!$('.supplier'+data[0]['SupplierNo']).length){
							$('#billSupError1').fadeIn("fast", function(){        
						        $("#billSupError1").fadeOut(4000);
						    });
						    return;
						}
					}
						$('.BillPaymentTable').append('<tr id="bill'+itemno+'"><td id="billitemno'+itemno+'">'+itemno+'</td><td id="billId'+id+'">'+id+'</td>
							<td class="supplier'+data[0]['SupplierNo']+'">'+data[0]['SupplierName']+'<td class="dp">'+data[0]['SalesInvoiceNo']+'</td><td class="dp Billcost">'+money(data['amount'])+'</td><td>
							<button class="btn btn-danger btn-xs square" id="removeBill'+itemno+'" onclick="removeBill('+itemno+')">
							<i class="fa fa-times"></i> Remove</button></td></tr>');
						itemno +=1;
							calcBillPaymentTotal();
							$('#saveBill,.cashChecque').removeClass('hidden');
						}
					
			});	
}
function removeBill(id){
	$('#bill'+id).remove();
	id +=1;
	if( $('#bill'+id).length ) 
	{
	  while(id<itemno){
			$('#bill'+id).attr('id','bill'+(id-1));
			$('#billitemno'+(id)).attr('id','itemno'+(id-1));
			$('#billitemno'+(id-1)).text(id-1);
			$('#removeBill'+(id)).attr('id','removeBill'+(id-1));
			$('#removeBill'+(id-1)).attr('onclick','removeBill('+(id-1)+')');
			id++;
		}
	}
	itemno -=1;
	calcBillPaymentTotal();
}
function calcBillPaymentTotal(){
	var total=0;
	var bal=0;
	if($('.Balcost').text()){
		bal = parseFloat($('.Balcost').text());
	}
	$('.Billcost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#BillPaymentTotalCost').text(money(total+bal));
	if(total ==0){
		$('#BillPaymentTotalCost').text(money(total));
		$('#invoicesTfoot').remove();
		$('#saveBill,.cashChecque,#saveSP').addClass('hidden');
	}
}

//Document Ready
$(document).ready(function(){

$('.add-user').click(function(event) {
	// alert('horaa');
	$('#userForm input[type="text"]').val('');
});

$('#user-library').on('hidden.bs.modal', function () {
    $('.user-pwd,.password,.retype-password').show();
    $('.password,.retype-password').attr('required');
});
$( "#invoiceDate" ).datepicker();

$('#edTerm,#vwSupplier').change(function(){
	$('#vwSavePOBtn').removeClass('hidden');
});
$('#edTerm1').click(function(){
	$('#vwSavePOBtn').removeClass('hidden');
});
$('#vwApproved').change(function(){
	var id=$('#edPOId').text();
	if($('#vwApproved').is(':checked')){
		var approve = 1;
	}else{
		var approve = 0;
	}
		$.post(reroute+'/approvePO',{id:id,ApprovedBy:approve},function(data){
	 	  	if(!data){
	 	  		$('#edApprovedBy').val('N/A');
	 	  		$('#App'+id).text('N/A');
	 	  		$('#App'+id).parent('tr').removeClass('success');
	 	  		$('#App'+id).parent('tr').addClass('warning');
	 	  	}else{
				$('#edApprovedBy').val(data);
	 	  		$('#App'+id).text(data);
	 	  		$('#App'+id).parent('tr').removeClass('warning');
	 	  		$('#App'+id).parent('tr').addClass('success');
	 	  	}
		});
});
// BILL APPROVAL
$('#billApproved').change(function(){
	var id=$('#vwSaveBillBtn').val();
	if($('#billApproved').is(':checked')){
		var approve = 1;
	}else{
		var approve = 0;
	}
		$.post(reroute+'/approveBill',{id:id,ApprovedBy:approve},function(data){
	 	  	if(!data){
	 	  		$('#AppBill'+id).text('N/A');
	 	  		$('#AppBill'+id).parent('tr').removeClass('success');
	 	  		$('#AppBill'+id).parent('tr').addClass('warning');
	 	  	}else{
	 	  		$('#AppBill'+id).text(data);
	 	  		$('#AppBill'+id).parent('tr').removeClass('warning');
	 	  		$('#AppBill'+id).parent('tr').addClass('success');
	 	  	}
		});
});
// END OF BILL APPROVAL
// SI APPROVAL
$('#SIApproved').change(function(){
	var id=$('#vwSaveSIBtn').val();
	if($('#SIApproved').is(':checked')){
		var approve = 1;
	}else{
		var approve = 0;
	}
		$.post(reroute+'/approveSI',{id:id,ApprovedBy:approve},function(data){
	 	  	if(!data){
	 	  		$('#App'+id).text('N/A');
	 	  		$('#App'+id).parent('tr').removeClass('success');
	 	  		$('#App'+id).parent('tr').addClass('warning');
	 	  	}else{
	 	  		$('#App'+id).text(data);
	 	  		$('#App'+id).parent('tr').removeClass('warning');
	 	  		$('#App'+id).parent('tr').addClass('success');
	 	  	}
		});
});
// END OF SI APPROVAL
$('#POCancelBtn').click(function(){
	var id=$('#edPOId').text();
		$.post(reroute+'/cancelPO',{id:id},function(data){
	 	  	$('#CancelledBy'+id).text(data);
	    	location.reload();
				if(document.title == 'Purchase'){
					$(location).attr('href','/PurchaseOrders#showPOList');
				}
		});
});
$('#BillCancelBtn').click(function(){
	var id=$('#vwSaveBillBtn').val();
	alert(id);
		$.post(reroute+'/cancelBill',{id:id},function(data){
	 	  	location.reload();
				if(document.title == 'Bills'){
					$(location).attr('href','/Bills#BillsList');
				}
		});
});
$('#SICancelBtn').click(function(){
	var id=$('#vwSaveSIBtn').val();
		$.post(reroute+'/cancelSI',{id:id},function(data){
	 	  	location.reload();
				if(document.title == 'Invoice'){
					$(location).attr('href','/SalesInvoice#showSIList');
				}
		});
});
//Verify current password
$('#current-password').blur(function(event) {
	/* Act on the event */
	var val = $(this).val();
	// alert (val);
	$.get(reroute+'verifyCurrentPassword',{val:val},function(data){
  		if(data == '0'){
  			$('#isCurrentPW').val('0');
  			$('.alert').show();
  		}else{
  			$('#isCurrentPW').val('1');
  			$('.alert').hide();
  		}
  	});
});

// TAB PANE active 

	
$.fn.editable.defaults.mode = 'inline';
	$(".pops").popover({ trigger: "hover" });
	$('.add-customer').click(function(event) {
			$('#library-action').val('');
			$('.name').val('');
  			$('.address').val('');
  			$('.telephone1').val('');
  			$('.telephone2').val('');
  			$('.contact-person').val('');
  			$('.credit-limit').val('');
  			$('.delete').hide();
		});
	$('.add-branch').click(function(event) {
			$('#library-action').val('');
			$('.name').val('');
  			$('.address').val('');
  			$('.telephone').val('');
  			$('.delete').hide();
		});
	$('.add-bank').click(function(event) {
			$('#library-action').val('');
			$('.name').val('');
  			$('.address').val('');
  			$('.telephone').val('');
  			$('.delete').hide();
		});
	$('.add-cm').click(function(event) {
			$('#library-action').val('');
			$('#remarks').val('');
  			$('#amount').val('');
		});
		
//sidebar collapse
	var a = document.title;
	document.getElementsByTagName("body")[0].id = a;
//navigation automatic dropdown
		$('ul.nav li.dropdown').hover(function() {
			$('.dropdown-menu', this).fadeIn();
		}, function() {
			$('.dropdown-menu', this).fadeOut('fast');
		});
//set active navbar
		$("#SB"+a).addClass('active');
//set active sidebar
		$("#SB"+a+" a:contains("+a+")").parent().addClass('active');
		$("#SB"+a).parent().parent().removeClass('collapse');
		// $(".sidehead ul:contains #SB"+a).removeClass('collapse');

	$("#sidebar-wrapper").hover(function(e) {
	        e.preventDefault();
	        $("#wrapper").addClass("toggled");
	    }, function() {
		$("#wrapper").removeClass('toggled');
	});	
	$('#ProductCategory').keyup(function(){
		$('#catError').addClass('hidden');
	});
$('#saveCategory').click(function(e){
		e.preventDefault(); 
      var category=jQuery.trim($('#ProductCategory').val());
      if((!category) || category.length == 0){
      	$('#catError').text('Category text field is empty!');
      	$('#catError').removeClass('hidden');
      }else{
      	  var table=  $('.category').dataTable(); 
	 	  $.post(reroute+'/addCategory',{ProdCatName:category},function(data){
	 	  	if(data == 0){
	 	  		$('#catError').text('Category already exists!');
      			$('#catError').removeClass('hidden');
	 	  	}else{
	 	  		// table.row.add( [
		     //        data['updated_at'],data['ProdCatName'],'<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
		     //    ]).draw();
		        var rowid = table.fnAddData( [
				     data['updated_at'],
				    data['ProdCatName'],
				    '<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
				     ] );
				var theNode = table.fnSettings().aoData[rowid[0]].nTr;
				theNode.setAttribute('id', 'category'+data['id']);
		        // var row = table.rows( '.selected' ).indexes();
		        // var thisRow= $(row).attr( 'id', 'category'+data['id'] );
		        $('#category'+data['id']+' td:nth-child(1)').attr( 'id', 'catName'+data['id'] );
		        $('#catError').addClass('hidden');
	        }
	      });
      }
      $('#ProductCategory').val(' ');
});
$('#categoryBtn').click(function(){
	var table = $('.category').DataTable();
	var id= $('#catID').val();
	var index = $('#catIndex').val();
	var ProdCatName = $('#txtCatName').val();
	var category=jQuery.trim($('#txtCatName').val());
      if((!category) || category.length == 0){
      	$('#modalCatError').text('Text field is empty!');
      	$('#modalCatError').removeClass('hidden');
      }else{
      		$.post(reroute+'/editCategory',{id:id,ProdCatName:ProdCatName},function(data){
      			if(data == 0){
		 	  		$('#modalCatError').text('Category already exists!');
	      			$('#modalCatError').removeClass('hidden');
		 		}else{
			        table.cell( index, 1 ).data( data ).draw();
			        $('#myModal').modal('hide');
			    }
			});
	  }
});
$('#addSupplier').click(function(){
	$('.modal-title').text('Add new Supplier');
	$('#txtSupID').val(null);
	$('input[type=text]').val(null);
	$('#supplierModal').modal('show');

});
$('#addProduct').click(function(){
	$('.modal-title').text('Add new Product');
	$('#txtProdID').val(null);
	$('input[type=text]').val(null);
	$('#productModal').modal('show');

});
//SIDEBAR CLICK COLLAPSE
$('.sidehead').click(function() {
		$(this).children('ul').first().stop(true, true).slideToggle(500);;
	});
//numbers only validation
$('#telephone,#telephone1,#telephone2').keydown(function(event) {
	if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            //key exemptions
            if(event.keyCode != 8 && event.keyCode != 9 && event.keyCode != 107 && event.keyCode != 187 && event.keyCode != 116 && event.keyCode != 16 && event.keyCode != 109 && event.keyCode != 189){
            	$('.alert').show();
            	event.preventDefault();
            }
        }
    else{
    	$('.alert').hide();
    }
});
// PO TERM 
//term check
$('#term2,#edTerm2,#billTerm2').click(function() {
	$('#termBox,#edTermBox,#billTermBox').removeClass('hidden');
	$('#term1,#edTerm1,#billTerm1').removeClass('active');
	$('#term,#edTerm,#billTerm').select();
});
$('#term1,#edTerm1,#billTerm1').click(function() {
	$('#termBox,#edTermBox,#billTermBox').addClass('hidden');
	$('#term2,#edTerm2,#billTerm2').removeClass('active');
	$('#term,#edTerm,#billTerm').val(0);
});
$('#term,#edTerm,#billTerm').blur(function() {
	var value=jQuery.trim($(this).val());
	if(value==''){
		$(this).val(0);
	}
});
$("#term,#edTerm,#billTerm,#invoiceno").keydown(function(e){
		numberOnlyInput(e);
});
$(".numberOnly").keydown(function(e){
		numberOnlyInput(e);
});
//END OF PO TERM
$('#addProductPO').click(function(){
	$('#addProductPOModal').modal('show');
});
//SAVE PO
$('#savePO').click(function(){
	var TableData;
	var supplier = $('#supplier').val();
	var term = $('#term').val();
	var preparedBy= $('#preparedBy').text();
	if($('#approved').is(':checked')){
			var approvedBy=preparedBy;
		} else{
			var approvedBy='';
		}
	TableData = storeTblValues()
	TableData = $.toJSON(TableData);

	$.post(reroute+'/savePO',{TD:TableData,supplier:supplier,term:term,preparedBy:preparedBy,approvedBy:approvedBy},function(data){
			if(data==1){
				location.reload();
				 $('#successModal').modal('show');
				 $(location).attr('href','/PurchaseOrders#showPOList');
			}else if(data==0){
				$('#savePOError').fadeIn("fast", function(){        
			        $("#savePOError").fadeOut(4000);
			    });
			}
		});
	function storeTblValues()
	{
		var TableData = new Array();
		$('.POtable tr').each(function(row, tr){
		    TableData[row]={
		        "ProdNo" : $(tr).find('td:eq(1)').text()
		        , "Unit" :$(tr).find('td:eq(4)').text()
		        , "Qty" : $(tr).find('td:eq(5)').text()
		        , "CostPerQty" : $(tr).find('td:eq(6)').text()
		    }
		});
		TableData.shift();
	    return TableData;
	}
});
$('#vwSavePOBtn').click(function(){
	var TableData;
	var id = $('#edPOId').text();
	var supplier = $('[name="vwSupplier"]').val();
	var term = $('#edTerm').val();
	TableData = storeTblValues()
	TableData = $.toJSON(TableData);

	$.post(reroute+'/saveEditedPO',{TD:TableData,supplier:supplier,term:term,id:id},function(data){
			if(data==1){
				location.reload();
				if(document.title == 'Purchase'){
					$(location).attr('href','/PurchaseOrders#showPOList');
				}
			}else if(data==0){
				alert('invalid move');
			}
		});
	function storeTblValues()
	{
		var TableData = new Array();
		$('.edPOTable tr').each(function(row, tr){
		    TableData[row]={
		        "ProdNo" : $(tr).find('td:eq(1)').text()
		        , "Unit" :$(tr).find('td:eq(4)').text()
		        , "Qty" : $(tr).find('td:eq(5)').text()
		        , "CostPerQty" : $(tr).find('td:eq(6)').text()
		    }
		});
		TableData.shift();
	    return TableData;
	}
});
$('#saveBillPOBtn').click(function(){
	var TableData;
	var id = $('#billPOId').text();
	var term = $('#billTerm').val();
	var SalesInvoiceNo = $('#invoiceno').val();
	var SalesInvoiceDate = $('#invoicedate').val();
	if($('#billApprove').is(':checked')){
			var approvedBy=1;
		} else{
			var approvedBy='';
		}
	TableData = storeTblValues1()
	TableData = $.toJSON(TableData);
	$.post(reroute+'/savePOBill',{TD:TableData,term:term,id:id,SalesInvoiceNo:SalesInvoiceNo,SalesInvoiceDate:SalesInvoiceDate,ApprovedBy:approvedBy},function(data){
			if(data==1){
				location.reload();
				if(document.title == 'Purchase'){
					$(location).attr('href','/PurchaseOrders#showPOList');
				}
			}else if(data==0){
				$('#billError').fadeIn("fast", function(){        
				        $("#billError").fadeOut(4000);
				});
			}
		});
	function storeTblValues1()
	{
		var TableData = new Array();
		$('.BillPOTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "ProductNo" : $(tr).find('td:eq(1)').text()
		    	, "Unit" :$(tr).find('td:eq(4)').text()
		        ,"LotNo" : $(tr).find('td:eq(5)').text()
		        , "ExpiryDate" :$(tr).find('td:eq(6)').text()
		        , "Qty" :$(tr).find('td:eq(7)').text()
		        , "CostPerQty" : $(tr).find('td:eq(8)').text()
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});
// SAVE BILL
$('#vwSaveBillBtn').click(function(){
	var TableData;
	var id = $('#vwSaveBillBtn').val();
	var term = $('#billTerm').val();
	var SalesInvoiceNo = $('#invoiceno').val();
	var SalesInvoiceDate = $('#invoicedate').val();

	TableData = storeTblValues1()
	TableData = $.toJSON(TableData);
	$.post(reroute+'/saveEditedPOBill',{TD:TableData,term:term,id:id,SalesInvoiceNo:SalesInvoiceNo,SalesInvoiceDate:SalesInvoiceDate},function(data){
			if(data==1){
				location.reload();
				if(document.title == 'Purchase_Orders'){
					$(location).attr('href','/PurchaseOrders#showPOList');
				}
			}else if(data==0){
				$('#billError').fadeIn("fast", function(){        
				        $("#billError").fadeOut(4000);
				});
			}
		});
	function storeTblValues1()
	{
		var TableData = new Array();
		$('.BillPOTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "ProductNo" : $(tr).find('td:eq(1)').text()
		    	, "Unit" :$(tr).find('td:eq(4)').text()
		        ,"LotNo" : $(tr).find('td:eq(5)').text()
		        , "ExpiryDate" :$(tr).find('td:eq(6)').text()
		        , "Qty" :$(tr).find('td:eq(7)').text()
		        , "CostPerQty" : $(tr).find('td:eq(8)').text()
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});
// END OF SAVE BILL
// SAVE SI
$('#saveBillSOBtn').click(function(){
	// $('#printSI').modal('show');

	var TableData;
	var id = $('#billSOId').text();
	var term = $('#billTerm').val();
	var RefDocNo = $('#invoiceno').val();
	var SalesInvoiceDate = $('#invoicedate').val();
	if($('#billApprove').is(':checked')){
			var approvedBy=1;
		} else{
			var approvedBy='';
		}
	TableData = storeTblValuesSI()
	TableData = $.toJSON(TableData);
	$.post(reroute+'/saveSOBill',{TD:TableData,term:term,id:id,RefDocNo:RefDocNo,SalesInvoiceDate:SalesInvoiceDate,ApprovedBy:approvedBy}).done(function(data){
			if(data==1){
				if($('#billApprove').length){
					if(approvedBy == 1){
						$("#SIPrintable").printThis({
					     debug: false,             
					     importCSS: false,           
					     printContainer: true,       
					     pageTitle: "Sales Invoice",              
					     removeInline: false,        
					     printDelay: 333,           
					     header: null,              
					     formValues: true,
					     page:'A3',
					     margins:'none'           
					  });
					}else{

						$(location).attr('href','/SalesInvoice#showSIList');
					}
				}
				return;
				// location.reload();
				if(document.title == 'Invoice'){
					$(location).attr('href','/SalesInvoice#showSIList');
				}
			}else if(data==0){
				$('#billError').fadeIn("fast", function(){        
				        $("#billError").fadeOut(4000);
				});
			}
		});
	function storeTblValuesSI()
	{
		var TableData = new Array();
		$('.BillSOTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "ProductNo" : $(tr).find('td:eq(1)').text()
		    	, "Unit" :$(tr).find('td:eq(4)').text()
		        ,"LotNo" : $(tr).find('td:eq(5)').text()
		        , "ExpiryDate" :$(tr).find('td:eq(6)').text()
		        , "Qty" :$(tr).find('td:eq(7)').text()
		        , "CostPerQty" : $(tr).find('td:eq(8)').text()
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});
// END OF SAVING SI
// SAVE EDITED SI
$('#vwSaveSIBtn').click(function(){
	var TableData;
	var id = $('#vwSaveSIBtn').val();
	var term = $('#billTerm').val();
	var RefDocNo = $('#invoiceno').val();
	var SalesInvoiceDate = $('#invoicedate').val();

	TableData = storeTblValues1()
	TableData = $.toJSON(TableData);
	$.post(reroute+'/saveEditedSI',{TD:TableData,term:term,id:id,RefDocNo:RefDocNo,SalesInvoiceDate:SalesInvoiceDate},function(data){
			if(data==1){
				location.reload();
				if(document.title == 'Invoice'){
					$(location).attr('href','/SalesInvoice#showSIList');
				}
			}else if(data==0){
				$('#billError').fadeIn("fast", function(){        
				        $("#billError").fadeOut(4000);
				});
			}
		});
	function storeTblValues1()
	{
		var TableData = new Array();
		$('.BillSOTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "ProductNo" : $(tr).find('td:eq(1)').text()
		    	, "Unit" :$(tr).find('td:eq(4)').text()
		        ,"LotNo" : $(tr).find('td:eq(5)').text()
		        , "ExpiryDate" :$(tr).find('td:eq(6)').text()
		        , "Qty" :$(tr).find('td:eq(7)').text()
		        , "CostPerQty" : $(tr).find('td:eq(8)').text()
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});
// END OF SAVE EDITED SI
// BILL PAYMENTS READY FXN
$('#billCheque').click(function(){
	// if($('#billCheque').is(':checked')){
			$('.chequeDiv').removeClass('hidden');
			$('.cashDiv').addClass('hidden');
			var supplier;
			$('.BillPaymentTable > tbody > tr').each(function(row, tr){
				supplier = $(tr).find('td:eq(2)').text();
			});
			$('#payTo').val(supplier);
});
$('#billCash').click(function(){
			$('.cashDiv').removeClass('hidden');
			$('.chequeDiv').addClass('hidden');

});
// $('#cashVoucher').click(function(){
// 	var itemno = 1;
// 	var supplier;
// 	$('#cashVoucherTable > tbody > tr').remove();
// 	$('.BillPaymentTable > tbody > tr').each(function(row, tr){
// 		supplier = $(tr).find('td:eq(2)').text();
// 		$('#cashVoucherTable').append('<tr>
// 							<td colspan="7">Bill No '+$(tr).find('td:eq(1)').text()+'</td>
// 							<td class="dp"><i style="padding-right:8%;">'+$(tr).find('td:eq(4)').text()+'</i></td>
// 							</tr>');
// 	});
// 	$('.cashVoucherTotal').text($('#BillPaymentTotalCost').text());
// 	var words =  toWords(Number($('#BillPaymentTotalCost').text()).toFixed(0));
// 	$('#cvReceivedFrom').text(supplier);
// 	$('#wordVoucherTotal').text(words);
// 	$('#cashVoucherModal').modal('show');
// 	$("#cashVoucherPrintable").printThis({
// 	     debug: false,             
// 	     importCSS: true,           
// 	     printContainer: true,       
// 	     pageTitle: "Cash Voucher",              
// 	     removeInline: false,        
// 	     printDelay: 333,           
// 	     header: null,              
// 	     formValues: true            
// 	  });
// });

// $('#chequeVoucher').click(function(){
// 	if(!$('#chequeNo').val().length || !$('#chequeDueDate').val().length || !$('#payTo').val().length){
// 		$('#chequeError').fadeIn("fast", function(){ 
// 	        $("#chequeError").fadeOut(4000);
// 	    });
// 	    return;
// 	}
// 	var payTo = $('#payTo').val();
// 	$('.chequeVoucherTotal').text($('#BillPaymentTotalCost').text());
// 	var words =  toWords(Number($('#BillPaymentTotalCost').text()).toFixed(0));
// 	 $('#wordchequeTotal').text(words);
// 	 $('#chequeSupplier').text($('#payTo').val());
// 	 $('#chequeVoucherNo').text($('#chequeNo').val());
// 	 $('#chequeVoucherBank').text($('#bankNo').find("option:selected").text());
// 	 $('#chequeVoucherDueDate').text($('#chequeDueDate').val());
// 	 $('#chequeModal').modal('show');
// });
// $('#chequeVoucher').click(function(){
	
// });


$('#saveBill').click(function(){
	var id = $('#BPediting').val();
	var TableData;
	TableData = storeBillValues();	 
	TableData = $.toJSON(TableData);
	var amount= $('#BillPaymentTotalCost').text();
	if($('#billCash').is(':checked')){
		var paymentType=0;
		var cashVoucherNo=$('#cashVoucherNo').text();
	}else if($('#billCheque').is(':checked')){
		if(!$('#chequeNo').val().length || !$('#chequeDueDate').val().length || !$('#payTo').val().length){
			$('#chequeError').fadeIn("fast", function(){ 
		        $("#chequeError").fadeOut(4000);
		    });
		    return;
		}
		var paymentType =1;
		var checkVoucherNo =  $('#chequeVaucherNo').text();
		var checkNo = $('#chequeNo').val();
		var checkDueDate = $('#chequeDueDate').val();
		var BankNo = $('#bankNo').find("option:selected").val();
		var PayTo = $('#payTo').val();	
	}
	if($('#approvedBillPayment').is(':checked')){
		var approved =1;
	}else{
		var approved =0;		
	}
	$.post(reroute+'/billPayment',{id:id,TD:TableData,amount:amount,type:paymentType,cashVoucherNo:cashVoucherNo,checkNo:checkNo,
	checkVoucherNo:checkVoucherNo,checkDueDate:checkDueDate,BankNo:BankNo,approved:approved,PayTo:PayTo}).done(function(data){
		if(approved == 1){
			if(paymentType==0){
				printCashVoucher();
			}else{
				printCheckVoucher();
			}
		}
		$(location).attr('href','/BillPayments#BillPaymentList');
	});
	function storeBillValues(){
		var TableData = new Array();
		$('.BillPaymentTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "BillNo" : $(tr).find('td:eq(1)').text()
		    	 , "amount" :$(tr).find('td:eq(4)').text()
		    }
		});
	    return TableData;
	}
	
});
// END OF BILL PAYMENTS READY FXN
// EDIT BILL PAYMENT
$('.editBillPayment').click(function(){
	var id= $(this).val();
	var itemno=1;
	$('#BPediting').val(id);
	$('.BillPaymentTable >tbody > tr').remove();
	$.post(reroute+'/getbillPayments',{id:id},function(bills){
		$('.billPaymentEditId').text(bills['id']);
		if(bills['PaymentType']==0){
			$('.cashDiv').removeClass('hidden');
			$('.chequeDiv').addClass('hidden');
			$('#billCash').prop("checked", true);
			$('#cashVoucherNo').text(bills['CashVoucherNo']);
		}else if(bills['PaymentType']==1){
			$('.chequeDiv').removeClass('hidden');
			$('.cashDiv').addClass('hidden');
			$('#bankNo').val(bills['BankNo']);
			$('#billCheque').prop("checked", true);
			$('#chequeNo').val(bills['CheckNo']);
			$('#payTo').val(bills['PayTo']);
			var chDate = new Date(bills['CheckDueDate']);
			$('#chequeDueDate').val((chDate.getMonth() + 1) + '/' + chDate.getDate() + '/' +  chDate.getFullYear());
		}
		if(bills['ApprovedBy']){
			$('#approvedBillPayment').prop('checked', true);
		}else{
			$('#approvedBillPayment').prop('checked', false);
		}
	});
	$.post(reroute+'/getbillPaymentDetails',{id:id},function(billdetails){
		$.each(billdetails, function(key,value) {
			$('.BillPaymentTable').append('<tr id="bill'+itemno+'"><td id="billitemno'+itemno+'">'+itemno+'</td><td id="billId'+value.BillNo+'">'+value.BillNo+'</td>
				<td class="supplier'+value.SupplierNo+'">'+value.SupplierName+'</td><td class="dp">'+value.InvoiceNo+'</td><td class="dp Billcost">'+money(value.Amount)+'</td><td>
				<button class="btn btn-danger btn-xs square" id="removeBill'+itemno+'" onclick="removeBill('+itemno+')">
				<i class="fa fa-times"></i> Remove</button></td></tr>');
			itemno +=1;
			calcBillPaymentTotal();		
		});
	});
	
	
	 $('#saveBill,.cashChecque').removeClass('hidden');
	 $('#BillPaymentEditing').removeClass('hidden');
	 $('#myTab a[href="#BillPaymentEntry"]').tab('show');
});
// END OF EDIT BILL PAYMENT
// CANCEL BP EDITING
 $('#cancelBPEditing').click(function(){
 	location.reload();
 });
 //  END OF CANCEL BP EDITING

// SALES PAYMENT CHECK AND CASH FUNCTION
$('#SPCheck').click(function(){
	if($('#SPCheck').is(':checked')){
			$('.chequeDiv').removeClass('hidden');
		if($('#SPCash').is(':checked')){	
			$('.cashDiv').removeClass('hidden');
		}
	}else{
		$('.chequeDiv').addClass('hidden');
	}
});
$('#SPCash').click(function(){
	if($('#SPCash').is(':checked')){
		$('.cashDiv').removeClass('hidden');
	}else{
		$('.cashDiv').addClass('hidden');
	}
});
//SALES PAYMENTS SAVING FUNCTIONS
$('#saveSP').click(function(){
	// if($('#BillPaymentTotalCost').text() > $('#paymentTypeTotal').text()){
	// 	$('#checkBoxError').fadeIn("fast", function(){ 
	// 		        $("#checkBoxError").fadeOut(4000);
	// 	});
	// 	return;
	// }
	var id = $('#SPediting').val();
	var customer_id = $("#customer_id").val();
	var TableData;
	var advance=0;
	TableData = storeSPValues();	 
	TableData = $.toJSON(TableData);
	PaymentTypes = storePTValues();	 
	PaymentTypes = $.toJSON(PaymentTypes);
	var cashAmount= $('#BillPaymentTotalCost').text();
	if($('#approvedSP').is(':checked')){
		var approved =1;
	}else{
		var approved =0;		
	}
	// if($('#BillPaymentTotalCost').text() < $('#paymentTypeTotal').text()){
	// 	advance = $('#paymentTypeTotal').text() - $('#BillPaymentTotalCost').text();
	// }	
	$.post(reroute+'/salesPay',{id:id,customerNo:customer_id,TD:TableData,PT:PaymentTypes,advance:advance,customer_id:customer_id,approved:approved},function(data){
		location.reload();
			$(location).attr('href','/SalesPayment#SalesPaymentList');
	});
	function storeSPValues(){
		var TableData = new Array();
		$('.BillPaymentTable > tbody  > tr').each(function(row, tr){
		    TableData[row]={
		    	 "invoiceNo" : $(tr).find('td:eq(1)').text()
		    	 , "amount" :$(tr).find('td:eq(5)').text()
		    }
		});
	    return TableData;
	}
	function storePTValues(){
		var TableData = new Array();
		$('#cashCheckTable > tbody  > tr').each(function(row, tr){
			if($(tr).find('td:eq(0)').text() == 'Cash'){
				TableData[row]={
			    	 "PaymentType" : $(tr).find('td:eq(0)').text()
			    	 ,"amount" : $(tr).find('td:eq(1)').text()
			    }
			}
			else if(($(tr).find('td:eq(0)').text() == 'Check')){
			    TableData[row]={
			    	 "PaymentType" : $(tr).find('td:eq(0)').text()
			    	 ,"BankNo" :$(tr).find('.bankSelect ').find("option:selected").val()
			    	 ,"CheckNo" : $(tr).find('td:eq(2)').text()
			    	 ,"CheckDueDate" : $(tr).find('td:eq(3)').text()
			    	 ,"amount" : $(tr).find('td:eq(4)').text()
			    }
		    }
		});
	    return TableData;
	}
	
});
// EDIT SALES PAYMENT
$('.editSP').click(function(){
	var id= $(this).val();
	var itemno=1;
	var customer_id ;
	$('#SPediting').val(id);
	$('#cashCheckTable > tbody > tr').remove();
	PTcalcCost();
	$('.BillPaymentTable >tbody > tr').remove();
	$('#invoicesTfoot').remove();
	$.post(reroute+'/getSP',{id:id},function(bills){
		$('.billPaymentEditId').text(bills['id']);
		if(bills['ApprovedBy']){
			$('#approvedSP').prop('checked', true);
		}else{
			$('#approvedSP').prop('checked', false);
		}
	});
	$('#SPCash,#SPCheck,.cashDiv,.clearEdit').prop('checked',false);
	$('.clearEdit').val('');
	$('.cashDiv').addClass('hidden');
	$.post(reroute+'/getSPDetails',{id:id},function(SPdetails){
		$.each(SPdetails, function(key,value) {
			if(value.PaymentType==0){
				$('#SPCash').prop('checked',true);
				$('.cashDiv').removeClass('hidden');
				$('#cashAmount').val(money(value.amount));
			}
			if(value.PaymentType==1){
				$('#SPCheck').prop('checked',true);
				$('#chequeNo').val(value.CheckNo);
				var chDate = new Date(value.CheckDueDate);
				$('#chequeDueDate').val((chDate.getMonth() + 1) + '/' + chDate.getDate() + '/' +  chDate.getFullYear());
				$('#bankNo').val(value.BankNo);
				$('#checkAmount').val(money(value.amount));
				$('.chequeDiv').removeClass('hidden');
			}
		});
	});

	$.post(reroute+'/getSPInvoices',{id:id},function(SPI){
		$.each(SPI, function(key,value) {
			$('.BillPaymentTable').append('<tr id="bill'+itemno+'"><td id="billitemno'+itemno+'">'+itemno+'</td><td id="billId'+value.invoiceNo+'">'+value.invoiceNo+'</td>
				<td class="customer'+value.CustomerNo+'">'+value.CustomerName+'</td><td class="medrep'+value.UserNo+'">'+value.Lastname+', '+value.Firstname+' '+value.MI+'.<td class="dp">'+value.SalesInvoiceRefDocNo+'</td><td class="dp Billcost">'+money(value.amount)+'</td>
				<td><button class="btn btn-danger btn-xs square" id="removeBill'+itemno+'" onclick="removeBill('+itemno+')">
				<i class="fa fa-times"></i> Remove</button></td></tr>');
			itemno +=1;
			calcBillPaymentTotal();		
			customer_id = value.CustomerNo;
			$('#customer_id').val(value.CustomerNo);
		});

		$.post(reroute+'/getBal',{id:id},function(bal){
				if(bal < 0){
					$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(bal*(-1))+'</td><td>Balance</td></tr></tfoot>');
				}else if(bal > 0){
					$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(bal*(-1))+'</td><td>Advanced Payment</td></tr></tfoot>');
				}
				calcBillPaymentTotal();	
		});

		customer_id = $('#customer_id').val();
		$.post(reroute+'/checkPayments',{customer_id:customer_id},function(data){
		if(data > 0){
			$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5">Balance</td><td class="dp Balcost">'+money(data)+'</td><td></td></tr></tfoot>');
			calcBillPaymentTotal();
		}else if(data < 0){
			$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5">Advanced Payment</td><td class="dp Balcost">'+money(data)+'</td><td></td></tr></tfoot>');
			calcBillPaymentTotal();
		}
		});	
	});

	$.post(reroute+'/getPaymentTypes',{id:id},function(payment){
		if(payment.length){
			var paymentItem=1;
			$.each(payment, function(key,value) {	
				if(value.PaymentType == 0){
					$('#cashCheckTable').append('<tr id="PT'+paymentItem+'">
						<td colspan="4">Cash</td>
						<td class="PTeditable danger PTcost">'+value.amount+'</td>
						<td><button class="btn btn-danger btn-xs square" id="removePT'+paymentItem+'" onclick="removePT('+paymentItem+')">
						<i class="fa fa-times"></i> Remove</button></td></tr>');
				}
				if(value.PaymentType == 1){
					$('#cashCheckTable').append('<tr id="PT'+paymentItem+'">
						<td>Check</td>
						<td><select class="bankSelect form-control square" id="bankSelect'+paymentItem+'"></select></td><td class="numberEditable danger">'+value.CheckNo+'</td>
						<td class="dateEditable danger">'+value.CheckDueDate+'</td>
						<td class="PTeditable danger PTcost">'+value.amount+'</td>
						<td><button class="btn btn-danger btn-xs square" id="removePT'+paymentItem+'" onclick="removePT('+paymentItem+')">
						<i class="fa fa-times"></i> Remove</button></td></tr>');
					var bank = value.BankNo;
					// alert(bank +' '+paymentItem);
					$('#bankSelect'+paymentItem).append( $('<option></option>').val(bank).html(bank).attr('selected',true) );
					$.post(reroute+'/fetchBanks',function(data){
						$('.bankSelect').each(function(){
							$.each(data, function(key,value) {
								if(!$('.bankSelect').find('option[value='+value.id +']').length){
									$('.bankSelect').append( $('<option></option>').val(value.id).html(value.BankName) );
									}else{
									$('.bankSelect').find('option[value='+value.id +']').html(value.BankName);
									$('.bankSelect').each(function(){
										if(!$(this).find('option[value='+value.id +']').length){
											$(this).append( $('<option></option>').val(value.id).html(value.BankName) );
										}
									});
								}
							});
						});
					});

				}
				editableNumber(paymentItem);
					$('.PTeditable').editable({
							send: 'never', 
						    type: 'text',
						    validate: function(value) {
						        if($.trim(value) == '') {
						         return 'This field is required';
						        }
						        else if($.isNumeric(value) == '' || value==0) {
						            return 'Please input a valid number greater than 0';
						        }
						    },
						    emptytext:0,
						   display: function(value) {
						   		$(this).text(Number(value).toFixed(2));
						   		PTcalcCost();
								}
					});

				dateEditable(paymentItem);
				paymentItem++;
			});	
		}	
	});
	
	
	 $('#saveSP,.cashChecque').removeClass('hidden');
	 $('#BillPaymentEditing').removeClass('hidden');
	 $('#myTab a[href="#SalesPaymentEntry"]').tab('show');
});
// END OF EDIT BILL PAYMENT
// REPORTS SCRIPT
$('#report_type').change(function(){
	var value = $(this).val();
	$('.reportProducList').hide();
	$('.productDetailDiv').hide();
	$('.gainLossDiv').hide();
	if(value == 1){
		$.post(reroute+'/fetchInventorySummary',{},function(data){
			$('#reportsTable > thead').remove();
			$('#reportsTable ').append('<thead><tr><th>Product No</th><th>Prod. Description</th><th>Brand</th><th>Rtl Unit</th><th>Rtl Sale Qty</th><th>WhlSale Unit</th><th>WhlSale Sale Qty</th></tr></thead>');
			$('#reportsTable > tbody').remove();
			$.each(data, function(key,value) {
				$('#reportsTable').append('<tr ><td>'+value.ProductNo+'</td><td >'+value.ProductName+'</td>
					<td>'+value.BrandName+'</td><td>'+value.RetailUnit+'<td >'+Number(value.RetailSaleQty).toFixed(0)+'</td><td >'+value.WholeSaleUnit+'</td><td >'+Number(value.WholeSaleQty).toFixed(0)+'</td>
					</tr>');
			});
		});
	}else if(value == 2){
		$.post(reroute+'/fetchInventoryByLotNo',{},function(data){
			$('#reportsTable > thead').remove();
			$('#reportsTable ').append('<thead><tr><th>Product No</th><th>Prod. Description</th><th>Brand</th><th>Rtl Unit</th><th>Rtl Sale Qty</th><th>WhlSale Unit</th><th>WhlSale Sale Qty</th><th>Lot Number</th><th>Expiry Date</th></tr></thead>');
			$('#reportsTable > tbody').remove();
			$.each(data, function(key,value) {
				var chDate = new Date(value.ExpiryDate);
				$('#reportsTable').append('<tr ><td>'+value.ProductNo+'</td><td >'+value.ProductName+'</td>
					<td>'+value.BrandName+'</td><td>'+value.RetailUnit+'<td >'+Number(value.RetailSaleQty).toFixed(0)+'</td><td >'+value.WholeSaleUnit+'</td><td >'+Number(value.WholeSaleQty).toFixed(0)+'</td>
					<td >'+value.LotNo+'</td><td >'+(chDate.getMonth() + 1) + '/' + chDate.getDate() + '/' +  chDate.getFullYear()+'</td></tr>');
			});
		});
	}else if(value == 3){
		$('.reportProducList').show();
		$.post(reroute+'/fetchInventoryByStockCard',{},function(data){
			$('#reportsTable > thead').remove();
			$('#reportsTable ').append('<thead><tr><th>Trans Date</th><th>Trans Type</th><th>Ref Document</th><th>In Qty</th><th>Out Qty</th><th>Running Balance</th></tr></thead>');
			$('#reportsTable > tbody').remove();
			var bal = 0;
			$.each(data, function(key,value) {
				var TranDate = new Date(value.TranDate);
				bal = Number(Number(bal)+Number(value.InStock)+Number(value.OutStock)).toFixed(2);
				$('#reportsTable').append('<tr ><td>'+value.TranDate+'</td><td >'+value.SourceName+'</td><td >'+value.RefDoc+'</td>
					<td class="dp">'+Number(value.InStock).toFixed(2)+'</td><td class="dp">'+Number(value.OutStock).toFixed(2)+'<td class="dp">'+bal+'</td></tr>');
			});
		});	
	}else if(value == 4){
		$('.gainLossDiv').show();
		var fromdate =$( '#min' ).datepicker( "getDate" );
		var todate =$( '#max' ).datepicker( "getDate" );
		var medrep = $('#medReps').val();
		var from = fromdate.getFullYear() + '-' + (fromdate.getMonth()+1) + '-' + fromdate.getDate();
		var to = todate.getFullYear() + '-' + (todate.getMonth()+1) + '-' + todate.getDate();
		gainlossReport(medrep,from,to);
		function gainlossReport(medrep,from,to){
			$.post(reroute+'/fetchInventoryGainLoss',{medrep:medrep,from:from,to:to},function(data){
				$('#reportsTable > thead').remove();
				$('#reportsTable ').append('<thead><tr><th>Source Doc</th><th>Date</th><th>ProductNo</th><th>Product Desc</th><th>Qty</th><th>Unit Cost</th><th>Item Cost</th><th>Unit Price</th><th>Item Price</th></tr></thead>');
				$('#reportsTable > tbody').remove();
				var bal = 0;
				$.each(data, function(key,value) {
					var TranDate = new Date(value.TranDate);
					$('#reportsTable').append('<tr><td>'+value.SourceDoc+'</td><td>'+value.TransDate+'</td><td>'+value.ProductNo+'</td><td>'+value.ProductName+'</td><td>'+value.Qty+'</td><td>'+value.unitcost+'</td>
						<td>'+value.itemcost+'</td><td>'+value.UnitPrice+'</td><td>'+value.itemprice+'</td></tr>');
				
				});
			});	
		}
		$('#medReps,#min,#max').change(function(){
			var fromdate =$( '#min' ).datepicker( "getDate" );
			var todate =$( '#max' ).datepicker( "getDate" );
			var medrep = $('#medReps').val();
			var from = fromdate.getFullYear() + '-' + (fromdate.getMonth()+1) + '-' + fromdate.getDate();
			var to = todate.getFullYear() + '-' + (fromdate.getMonth()+1) + '-' + todate.getDate();
			gainlossReport(medrep,from,to);
		});
	}
});
});//end of ready function
// Bill Payment
function printCashVoucher(){
	var itemno = 1;
	var supplier;
	$('#cashVoucherTable > tbody > tr').remove();
	$('.BillPaymentTable > tbody > tr').each(function(row, tr){
		supplier = $(tr).find('td:eq(2)').text();
		$('#cashVoucherTable').append('<tr>
							<td colspan="7">Bill No '+$(tr).find('td:eq(1)').text()+'</td>
							<td class="dp"><i style="padding-right:8%;">'+$(tr).find('td:eq(4)').text()+'</i></td>
							</tr>');
	});
	$('.cashVoucherTotal').text($('#BillPaymentTotalCost').text());
	var words =  toWords(Number($('#BillPaymentTotalCost').text()).toFixed(0));
	$('#cvReceivedFrom').text(supplier);
	$('#wordVoucherTotal').text(words);
	// $('#cashVoucherModal').modal('show');
	$("#cashVoucherPrintable").printThis({
	     debug: false,             
	     importCSS: true,           
	     printContainer: true,       
	     pageTitle: "Cash Voucher",              
	     removeInline: false,        
	     printDelay: 333,           
	     header: null,              
	     formValues: true            
	  });
}
function printCheckVoucher(){
	$('#checkVoucherCheckNo').text($('#chequeNo').val())
	$('#checkVoucherBank').text($('#bankNo').find("option:selected").text())
	$('#checkVoucherDueDate').text($('#chequeDueDate').val())
	$('#checkVoucherPayTo').text($('#payTo').val())

	// Check voucher payment details table
	$('#checkVoucherTable > tbody > tr').remove();
	$('.BillPaymentTable > tbody > tr').each(function(row, tr){
		$('#checkVoucherTable').append('<tr>
							<td colspan="7">Bill No '+$(tr).find('td:eq(1)').text()+'</td>
							<td class="dp"><i style="padding-right:8%;">'+$(tr).find('td:eq(4)').text()+'</i></td>
							</tr>');
	});
	$('.checkVoucherTotal').text($('#BillPaymentTotalCost').text());
	var words =  toWords(Number($('#BillPaymentTotalCost').text()).toFixed(0));
	// end of check voucher payment details table
	// $('#checkVoucherModal').modal('show');
	$("#checkVoucherPrintable").printThis({
	     debug: false,             
	     importCSS: true,           
	     printContainer: true,       
	     pageTitle: "Cash Voucher",              
	     removeInline: false,        
	     printDelay: 333,           
	     header: null,              
	     formValues: true            
	  });
}
	
 //SALES PAYMENTS
 function prodReport(id){
			$.post(reroute+'/fetchInventoryByStockCardId',{id:id},function(data){
			$('#reportsTable > thead').remove();
			$('#reportsTable ').append('<thead><tr><th>Trans Date</th><th>Trans Type</th><th>Ref Document</th><th>In Qty</th><th>Out Qty</th><th>Running Balance</th></tr></thead>');
			$('#reportsTable > tbody').remove();
			var bal = 0;
				$.each(data, function(key,value) {
					var TranDate = new Date(value.TranDate);
					bal = Number(Number(bal)+Number(value.InStock)+Number(value.OutStock)).toFixed(2);
					$('#reportsTable').append('<tr ><td>'+value.TranDate+'</td><td >'+value.SourceName+'</td><td >'+value.RefDoc+'</td>
						<td class="dp">'+Number(value.InStock).toFixed(2)+'</td><td class="dp">'+Number(value.OutStock).toFixed(2)+'<td class="dp">'+bal+'</td></tr>');
				});
				$('#reportsTable').append('<tr ><td colspan="5" class="dp"><b>Remaining Qty:</b></td><td class="dp">'+bal+'</td></tr>');
				
				$('.productDetailDiv').show();
				$('#reportProdNo').text(data[0]['ProductNo']);
				$('#reportUnit').text(data[0]['WholeSaleUnit']);
				$('#reportProdDesc').text(data[0]['ProductName']);
				$('#reportProdBrand').text(data[0]['BranchName']);
				$('#reportProdQty').text(bal);
			});
 }
function addSItoSP(id){
	$.post(reroute+'/addInvoiceToSalesPayment',{id:id},function(data){
				if($('#billId'+id).length){
					$('#billError1').fadeIn("fast", function(){        
				        $("#billError1").fadeOut(4000);
				    });
				}else{	
					if($('#bill1').length){
						if(!$('.customer'+data['CustomerNo']).length){
							$('#billSupError1').fadeIn("fast", function(){        
						        $("#billSupError1").fadeOut(4000);
						    });
						    return;
						}
					}else{
						// if invoice list is empty
						$('#cashCheckTable > tbody').remove();
						PTcalcCost();
						$("#customer_id").val(data['CustomerNo']);
						var branch = data['BranchNo'];
						if(( $('#SPediting').val() ) && ($('#customer_id').val() == data['CustomerNo'])){
							$.post(reroute+'/getBal',{id:$('#SPediting').val()},function(bal){
									if(bal < 0){
										$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(bal*(-1))+'</td><td>Advanced Payment</td></tr></tfoot>');
									}else if(bal > 0){
										$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(bal*(-1))+'</td><td>Balance</td></tr></tfoot>');
									}
									calcBillPaymentTotal();	
							});
						}else{
							$.post(reroute+'/checkPayments',{customer_id:data['CustomerNo'],branch:branch},function(data){
								if(data > 0){
									$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(data)+'</td><td>Balance</td></tr></tfoot>');
									calcBillPaymentTotal();
								}else if(data < 0){
									$('.BillPaymentTable').append('<tfoot id="invoicesTfoot"><tr><td colspan="5"></td><td class="dp Balcost">'+money(data)+'</td><td>Advanced Payment</td></tr></tfoot>');
									calcBillPaymentTotal();
								}
								PTcalcCost();
							});	
						}
					}
						$('.BillPaymentTable').append('<tr id="bill'+itemno+'"><td id="billitemno'+itemno+'">'+itemno+'</td><td id="billId'+id+'">'+id+'</td>
							<td class="customer'+data['CustomerNo']+'">'+data['CustomerName']+'</td><td class="medrep'+data['UserNo']+'">'+data['Lastname']+', '+data['Firstname']+' '+data['MI']+'.<td class="dp">'+data['SalesInvoiceRefDocNo']+'</td><td class="dp Billcost">'+money(data['amount'])+'</td>
							<td><button class="btn btn-danger btn-xs square" id="removeBill'+itemno+'" onclick="removeBill('+itemno+')">
							<i class="fa fa-times"></i> Remove</button></td></tr>');
						itemno +=1;
							calcBillPaymentTotal();
							$('#saveSP,.cashChecque').removeClass('hidden');
						}	
	});	
	
}
function viewSP(id){
	$('#viewSPModal').modal('show');
	$('#vwbillNo').text(id);
	$.post(reroute+'/viewSP',{id:id},function(data){
		$('#vwbillNo').text(data['id']);
	 	$('[name="vwbillSPBranch"]').val(data['BranchNo']);
	 	$('#vwSPPreparedBy').val(data['PreparedBy']);
	 	$('#vwSPApprovedBy').val(data['ApprovedBy']);
		var PaymentDate = new Date(data['PaymentDate']);
		$('#paymentDate').text((PaymentDate.getMonth() + 1) + '/' + PaymentDate.getDate() + '/' +  PaymentDate.getFullYear());
	});
	var itemno=1;
	var total = 0;
	$('.BillSPTable > tbody').remove();
	$('#balTFoot').remove();
	$.post(reroute+'/getSPInvoices',{id:id},function(SPI){
		$.each(SPI, function(key,value) {
			$('.BillSPTable').append('<tr ><td>'+itemno+'</td><td id="billId'+value.invoiceNo+'">'+value.invoiceNo+'</td>
				<td class="customer'+value.CustomerNo+'">'+value.CustomerName+'</td><td class="medrep'+value.UserNo+'">'+value.Lastname+', '+value.Firstname+' '+value.MI+'.<td class="dp">'+value.SalesInvoiceRefDocNo+'</td><td class="dp vwBillcost">'+money(value.amount)+'</td>
				</tr>');
			itemno += 1;	
			// total += value.amount;
			$('#billSPCustomers').val( value.CustomerNo);
			vwBillcalcCost();
		});
	});
	$('.BillSPPaymentType > tbody').remove();
	$.post(reroute+'/getPaymentTypes',{id:id},function(payment){
		if(payment.length){
			var total=0;
			$.each(payment, function(key,value) {	
				if(value.PaymentType == 0){
					$('.BillSPPaymentType').append('<tr >
						<td colspan="4">Cash</td>
						<td >'+money(value.amount)+'</td></tr>');
				}
				if(value.PaymentType == 1){
					$('.BillSPPaymentType').append('<tr >
						<td>Check</td>
						<td>'+value.BankName+'</td>
						<td >'+value.CheckNo+'</td>
						<td >'+value.CheckDueDate+'</td>
						<td >'+money(value.amount)+'</td>
						</tr>');
				}
				total +=  parseFloat(value.amount);
				$('#pTTotal').text(money(total));
			});	
		}	
	});
	$.post(reroute+'/getBal',{id:id},function(bal){
		// $.each(bal, function(key,value) {
			if(bal < 0){
				$('.BillSPTable').append('<tfoot id="balTFoot"><tr><td colspan="5" class="dp">Balance</td><td class="dp vwBillcost">'+money(bal*(-1))+'</td></tr></tfoot>');
			}else if(bal > 0){
				$('.BillSPTable').append('<tfoot id="balTFoot"><tr><td colspan="5" class="dp">Advance</td><td class="dp vwBillcost">'+money(bal*(-1))+'</td></tr></tfoot>');
			}
			vwBillcalcCost();
	});
}
// Adding Payment  Type to list

var paymentItem=1;
function addPaymentType(){
	var type = $('#paymentType').val();
	if(type == 0){
		$('#cashCheckTable').append('<tr id="PT'+paymentItem+'">
			<td colspan="4">Cash</td>
			<td class="PTeditable danger PTcost">'+($('#BillPaymentTotalCost').text()-$('#paymentTypeTotal').text())+'</td>
			<td><button class="btn btn-danger btn-xs square" id="removePT'+paymentItem+'" onclick="removePT('+paymentItem+')">
			<i class="fa fa-times"></i> Remove</button></td></tr>');
	}
	if(type == 1){
		$('#cashCheckTable').append('<tr id="PT'+paymentItem+'">
			<td>Check</td>
			<td><select class="bankSelect form-control square"></select></td><td class="numberEditable danger"></td>
			<td class="dateEditable danger">'+(d.getFullYear()+1)+'-01-01</td>
			<td class="PTeditable danger PTcost">'+($('#BillPaymentTotalCost').text()-$('#paymentTypeTotal').text())+'</td>
			<td><button class="btn btn-danger btn-xs square" id="removePT'+paymentItem+'" onclick="removePT('+paymentItem+')">
			<i class="fa fa-times"></i> Remove</button></td></tr>');
		$.post(reroute+'/fetchBanks',function(data){
			$.each(data, function(key,value) {
				$('.bankSelect').each(function(){
					if(!$(this).find('option[value='+value.id +']').length){
						$(this).append( $('<option></option>').val(value.id).html(value.BankName) );
					}
				});
			});
		});
	}
	editableNumber(paymentItem);
		$('.PTeditable').editable({
				send: 'never', 
			    type: 'text',
			    validate: function(value) {
			        if($.trim(value) == '') {
			         return 'This field is required';
			        }
			        else if($.isNumeric(value) == '' || value==0) {
			            return 'Please input a valid number greater than 0';
			        }
			    },
			    emptytext:0,
			   display: function(value) {
			   		$(this).text(Number(value).toFixed(2));
			   		PTcalcCost();
					}
		});

	dateEditable(paymentItem);
	paymentItem++;
}
function removePT(id){
	$('#PT'+id).remove();
	id +=1;
	if( $('#PT'+id).length ) 
	{
	  while(id<itemno){
			$('#PT'+id).attr('id','PT'+(id-1));
			$('#removePT'+(id)).attr('id','removePT'+(id-1));
			$('#removePT'+(id-1)).attr('onclick','removePT('+(id-1)+')');
			id++;
		}
	}
	paymentItem -=1;
	PTcalcCost();
}
function PTcalcCost(){
		var total=0;
		$('.PTcost').each(function(){
			total += parseFloat($(this).text()); 
		});
		$('#paymentTypeTotal').text(Number(total).toFixed(2));
	}
function vwBillcalcCost(){
	var total=0;
	$('.vwBillcost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#vwBillSPTotalCost').text(Number(total).toFixed(2));
}
function editCategory(id){
	$('#modalCatError').addClass('hidden');
	var table = $('.category').DataTable();
	var catName= jQuery.trim($('#catName'+id).text());
	var index=table.row('#category'+id).index();
		$('#catID').val(id);
		$('#catIndex').val(index);
		$('#txtCatName').val(catName);
		$('#myModal').modal('show');
		$('.modal-title').text('Edit '+catName);
}
function editSupplier(id){
	var table=$('.supplier').DataTable();
			$('.modal-title').text('Edit Supplier');
	      	$('#supplierModal').modal('show');
		$.post(reroute+'/fetchSupplier',{id:id},function(data){
			$('#txtSupID').val(data['id']);
	      	$('#SupplierName').val(data['SupplierName']);
	      	$('#Address').val(data['Address']);
	      	$('#Telephone1').val(data['Telephone1']);
	      	$('#Telephone2').val(data['Telephone2']);
	      	$('#ContactPerson').val(data['ContactPerson']);
		});

}
function editProduct(id){
	var table=$('.product').DataTable();
			$('.modal-title').text('Edit Product');
	      	$('#productModal').modal('show');
		$.post(reroute+'/fetchProduct',{id:id},function(data){
			$('#txtProdID').val(data['id']);
	      	$('#ProductCatNo').val(data['ProductCatNo']);
	      	$('#ProductName').val(data['ProductName']);
	      	$('#BrandName').val(data['BrandName']);
	      	$('#WholeSaleUnit').val(data['WholeSaleUnit']);
	      	$('#RetailUnit').val(data['RetailUnit']);
	      	$('#RetailQtyPerWholeSaleUnit').val(data['RetailQtyPerWholeSaleUnit']);
	      	$('#Reorderpoint').val(data['Reorderpoint']);
	      	$('#Markup1').val(data['Markup1']);
	      	$('#Markup2').val(data['Markup2']);
	      	$('#Markup3').val(data['Markup3']);
	      	$('#ActiveMarkup').val(data['ActiveMarkup']);
		});

}

	//number only input
	function numberOnlyInput(e){
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
      	}
	}

	
	
