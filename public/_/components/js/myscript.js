$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    var hash = window.location.hash;
	  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
	 
});
//to DISABLE inspect element (COMMENT OUT BEFORE INSPECT VIEWING)
// window.oncontextmenu = function () {
//    return false;
// }
// document.onkeydown = function (e) { 
//     if (window.event.keyCode == 123 ||  e.button==2)    
//     return false;
// }
//
//PO FUNCTIONS
var itemno = 1;
var counter = 1;
var d = new Date();
function addPO(id){
		$.post('/addProductToPO',{id:id},function(data){
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
	$.post('/viewPO',{id:id},function(data){
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
	$.post('/viewPODetails',{id:id},function(data){
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
	 $.post('/viewPO',{id:id},function(data){
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
		 	$('#edTerm2').prop("disabled", false)
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
	 $.post('/viewPODetails',{id:id},function(data){
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
	 $.post('/viewPO',{id:id},function(data){
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
	 $.post('/viewPODetails',{id:id},function(data){
	  			$(".BillPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable >tbody').append('<tr id="billPO'+counter+'" class="billRow"><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="numberEditable danger"></td><td class="danger dateEditable">'+(d.getFullYear()+1)+'-01-01</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.CostPerQty).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.CostPerQty*value.Qty).toFixed(2)+'</td><td class="vweditable dp danger">0</td><td class="danger selectEditable dp"></td><td class="vweditable dp danger">0.00</td></tr>');
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
	$('#BillCancelBtn,#checkAlert,#billApproved').removeClass('hidden');
	$('#vwSaveBillBtn').val(id);
	$('#billPOModal').modal('show');
	$('#billNo').text('Bill No. '+id);
	$.post('/viewBill',{id:id},function(data){
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
	$.post('/viewBillDetails',{id:id},function(data){
	  			$(".BillPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable >tbody').append('<tr id="billPO'+counter+'" ><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="numberEditable danger">'+value.LotNo+'</td><td class="danger dateEditable">'+value.ExpiryDate+'</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.Cost).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.Cost*value.Qty).toFixed(2)+'</td><td class="vweditable dp danger">'+value.FreebiesQty+'</td><td class="danger selectEditable dp">'+value.FreebiesUnit+'</td><td class="vweditable dp danger">'+value.CostPerQty+'</td></tr>');
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
	$.post('/viewBill',{id:id},function(data){
		$('#vwbillPOId').text(data[0]['PurchaseOrderNo']);
	 	$('[name="vwBillSupplier"]').val(data[0]['SupplierNo']);
	 	$('#vwBillBranchName').val(data[0]['BranchName']);
	 	if(data[0]['Terms'] == '0'){
	 		$('#vwBillTerm').val('Cash');
		}else{
		 	$('#vwBillTerm').val(data[0]['Terms']);
		}
		// if(data[0]['ApprovedBy'] == ''){
	 // 		$('#billApproved').prop('checked', false);
	 // 	}else{
	 // 		$('#billApproved').prop('checked', true);
	 // 	}
	 $('#billDate').text(data[0]['BillDate']);
		var InvDate = new Date(data[0]['SalesInvoiceDate']);
		$('#vwBillInvoiceDate').val((InvDate.getMonth() + 1) + '/' + InvDate.getDate() + '/' +  InvDate.getFullYear());
		$('#vwBillInvoiceNo').val(data[0]['SalesInvoiceNo']);
	});
	$.post('/viewBillDetails',{id:id},function(data){
	  			$(".BillPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.BillPOTable >tbody').append('<tr ><td >'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td >'+value.LotNo+'</td><td >'+value.ExpiryDate+'</td><td class="dp" >'+value.Qty+'</td><td class="dp" >'+Number(value.Cost).toFixed(2)+'</td>
	  					<td class="dp success">'+Number(value.Cost*value.Qty).toFixed(2)+'</td><td class="dp ">'+value.FreebiesQty+'</td><td class="dp">'+value.FreebiesUnit+'</td><td class="dp ">'+value.CostPerQty+'</td></tr>');
		  			total+=value.Cost*value.Qty;
		  			counter+=1;
	  				});
	  				$('#vwBillTotalCost').text(Number(total).toFixed(2));
	      });
}
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
		        }else{
		        $('#vwSaveBillBtn').removeClass('hidden');
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
		        }else{
		        $('#vwSaveBillBtn').removeClass('hidden');
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
	        }else{
	        $('#vwSaveBillBtn').removeClass('hidden');
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
	        }else{
	        $('#vwSaveBillBtn').removeClass('hidden');
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
	$.get('toEditBank',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$.each(data, function(key,value) {
	  			$('#library-action').val(value.id);
	  			$('.name').val(value.BankName);
	  			$('.address').val(value.BAddress);
	  			$('.telephone').val(value.Telephone);
	  			$('.deactivate').attr('href', '/delete-bank/'+id+'');
	  			$('.delete').show();
  			});
  		}
  	});
$('#bank-library').modal('show');
}
//edit-delete branch
function triggerEditBranch(id){
	$.get('toEditBranch',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$.each(data, function(key,value) {
	  			$('#library-action').val(value.id);
	  			$('.name').val(value.BranchName);
	  			$('.address').val(value.BAddress);
	  			$('.telephone').val(value.Telephone);
	  			$('.deactivate').attr('href', '/delete-branch/'+id+'');
	  			$('.delete').show();
  			});
  		}
  	});
$('#branch-library').modal('show');
}
//edit-delete branch
function triggerEditCustomer(id){
	$.get('toEditCustomer',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$.each(data, function(key,value) {
	  			$('#library-action').val(value.id);
	  			$('.name').val(value.CustomerName);
	  			$('.address').val(value.Address);
	  			$('.telephone1').val(value.Telephone1);
	  			$('.telephone2').val(value.Telephone2);
	  			$('.contact-person').val(value.ContactPerson);
	  			$('.credit-limit').val(value.CreditLimit);
	  			$('.deactivate').attr('href', '/delete-customer/'+id+'');
	  			$('.delete').show();
  			});
  		}
  	});
 $('#customer-library').modal('show');
 }
function triggerEditUser(id){
	$.get('toEditUser',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			var usertype;
  			$.each(data, function(key,value) {
  				if (value.UserType == 1){
  					usertype = 'Admin';
  				} else if (value.UserType == 11){
  					usertype = 'Admin/Sales Rep';
  				} else if (value.UserType == 2){
  					usertype = 'Warehouse User';
  				} else if (value.UserType == 3){
  					usertype = 'Office Clerk';
  				} else if (value.UserType == 4){
  					usertype = 'Sales Rep';
  				}
	  			$('#library-action').val(value.id);
	  			$('.username').val(value.username);
	  			$('.lastname').val(value.Lastname);
	  			$('.firstname').val(value.Firstname);
	  			$('.mi').val(value.MI);
	  			$('.usertype').val(usertype);
	  			$('.deactivate').attr('href', '/delete-user/'+id+'');
	  			$('.delete').show();
  			});
  		}
  	});
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
//Document Ready
$(document).ready(function(){
$('.vweditable,.numberEditable,.selectEditable,.dateEditable,#invoiceno,#invoicedate,
	#billTerm').change(function(){
	$('#vwSaveBillBtn').removeClass('hidden');
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
		$.post('/approvePO',{id:id,ApprovedBy:approve},function(data){
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
$('#billApproved').change(function(){
	var id=$('#vwSaveBillBtn').val();
	if($('#billApproved').is(':checked')){
		var approve = 1;
	}else{
		var approve = 0;
	}
		$.post('/approveBill',{id:id,ApprovedBy:approve},function(data){
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
$('#POCancelBtn').click(function(){
	var id=$('#edPOId').text();
		$.post('/cancelPO',{id:id},function(data){
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
		$.post('/cancelBill',{id:id},function(data){
	 	  	location.reload();
				if(document.title == 'Bills'){
					$(location).attr('href','/Bills#BillsList');
				}
		});
});
//Verify current password
$('#current-password').blur(function(event) {
	/* Act on the event */
	var val = $(this).val();
	// alert (val);
	$.get('verifyCurrentPassword',{val:val},function(data){
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
		$("#"+a+" a:contains('"+a+"')").parent().addClass('active');
//set active sidebar
		$("#"+a+" a:contains("+a+")").parent().addClass('active');
		$(".sidehead ul:contains("+a+")").removeClass('collapse');

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
	 	  $.post('/addCategory',{ProdCatName:category},function(data){
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
      		$.post('/editCategory',{id:id,ProdCatName:ProdCatName},function(data){
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

	$.post('/savePO',{TD:TableData,supplier:supplier,term:term,preparedBy:preparedBy,approvedBy:approvedBy},function(data){
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

	$.post('/saveEditedPO',{TD:TableData,supplier:supplier,term:term,id:id},function(data){
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
	$.post('/savePOBill',{TD:TableData,term:term,id:id,SalesInvoiceNo:SalesInvoiceNo,SalesInvoiceDate:SalesInvoiceDate,ApprovedBy:approvedBy},function(data){
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
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		        , "CostPerQty" : $(tr).find('td:eq(12)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});
$('#vwSaveBillBtn').click(function(){
	var TableData;
	var id = $('#vwSaveBillBtn').val();
	var term = $('#billTerm').val();
	var SalesInvoiceNo = $('#invoiceno').val();
	var SalesInvoiceDate = $('#invoicedate').val();

	TableData = storeTblValues1()
	TableData = $.toJSON(TableData);
	$.post('/saveEditedPOBill',{TD:TableData,term:term,id:id,SalesInvoiceNo:SalesInvoiceNo,SalesInvoiceDate:SalesInvoiceDate},function(data){
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
		        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
		        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
		        , "CostPerQty" : $(tr).find('td:eq(12)').text()
		    }
		});
		// TableData.shift();
	    return TableData;
	}	
});

});//end of ready function
function editCategory(id){
	$('#modalCatError').addClass('hidden')
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
		$.post('/fetchSupplier',{id:id},function(data){
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
		$.post('/fetchProduct',{id:id},function(data){
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

	
	
