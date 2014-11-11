$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    var hash = window.location.hash;
	  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
});


//PO FUNCTIONS
var itemno = 1;
var counter = 1;
function addPO(id){
	var name= $('#name'+id).text();
	var brand= $('#brand'+id).text();
	var unit= $('#unit'+id).text();
	var table = $('.product').DataTable();
	var index=table.row('#rowProd'+id).index();
	$('.POtable').append('<tr id="PO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+itemno+'">'+id+'</td>
		<td>'+name+'</td><td>'+brand+'</td><td>'+unit+'</td>
		<td class="light-green editable" id="prodQty'+id+'">'+1+'</td><td class="light-red editable" id="prodUnit'+id+'"></td>
		<td class="cost" id="prodCost'+id+'">0.00</td><td >
		<button class="btn btn-danger btn-xs square" id="removePO'+itemno+'" onclick="removePO('+itemno+','+id+','+index+')">
		<i class="fa fa-times"></i> Remove</button></td></tr>');
	itemno +=1;
	table.cell( index, 4 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
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
			   		$(this).text(value);
			        calcCost(id);
					}
			});
		$('#savePO').removeClass('hidden');
}
function calcCost(id){
	var qty = $('#prodQty'+id).text();
	var unit = $('#prodUnit'+id).text();
	$('#prodCost'+id).text(qty*unit);
	totalCost();
}
function totalCost(){
	var total=0;
	$('.cost').each(function(){
		total += parseInt($(this).text()); 
	});
	$('#POTotalCost').text(total);
	if(total = 0){
		$('#savePO').addClass('hidden');
	}
}
function removePO(id,prodId,index){
	var table = $('.product').DataTable();
		table.cell( index, 4 ).data('<button class="btn btn-success btn-xs square" 
			onclick="addPO('+prodId+')" >
			<i class="fa fa-check-circle"></i> Add</button>').draw();
	$('#PO'+id).remove();
	id +=1;
	if( $('#PO'+id).length ) 
	{
	  while(id<itemno){
			$('#PO'+id).attr('id','PO'+(id-1));
			$('#itemno'+(id)).attr('id','itemno'+(id-1));
			$('#itemno'+(id-1)).text(id-1);
			$('#productId'+id).attr('id','productId'+(id-1));
			$('#removePO'+(id)).attr('id','removePO'+(id-1));
			prodId = $('#productId'+(id-1)).text();
			index = table.row('#rowProd'+prodId).index();
			$('#removePO'+(id-1)).attr('onclick','removePO('+(id-1)+','+prodId+','+index+')');
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
	      });
	$.post('/viewPODetails',{id:id},function(data){
	  			$(".vwPOTable > tbody").html("");
	  			    counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.vwPOTable >tbody').append('<tr ><td>'+counter+'</td><td>'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td>'+value.Qty+'</td><td>'+value.CostPerQty+'</td>
	  					<td>'+(value.CostPerQty*value.Qty)+'</td></tr>');
		  			counter+=1;
		  			total+=value.CostPerQty*value.Qty;
	  				});
	  				$('#vwTotalCost').text(total);
	      });
}
function editPO(id){
	$('#vwSaveBtn').addClass('hidden');
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
	 	}else{
	 		$('#edApprovedBy').val(data[0]['ApprovedBy']);
	 	}
	      });
	 $.post('/viewPODetails',{id:id},function(data){
	  			$(".edPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+value.ProductNo+'">'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="vweditable" id="edQty'+value.ProductNo+'">'+value.Qty+'</td><td class="vweditable" id="edUnit'+value.ProductNo+'">'+value.CostPerQty+'</td>
	  					<td class="ecost"id="edCost'+value.ProductNo+'">'+(value.CostPerQty*value.Qty)+'</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
		  			total+=value.CostPerQty*value.Qty;
	  				editable(value.ProductNo);
		  			counter+=1;
	  				});
	  				$('#edTotalCost').text(total);
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
		        $('#vwSavePOBtn').removeClass('hidden');
		        }
		    },
		    emptytext:0,
		   display: function(value) {
		   		$(this).text(value);
		        edcalcCost(id);
				}
	});
}
function edcalcCost(id){
	var qty = $('#edQty'+id).text();
	var unit = $('#edUnit'+id).text();
	$('#edCost'+id).text(qty*unit);
	edtotalCost();
}
function edtotalCost(){
	var total=0;
	$('.ecost').each(function(){
		total += parseInt($(this).text()); 
	});
	$('#edPOTotalCost').text(total);
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
	if($('#vwProd'+id).length){prodError
		 $('#prodError').fadeIn("fast", function(){        
	        $("#prodError").fadeOut(4000);
	    });
	}else{
	$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+id+'">'+id+'</td>
	  					<td>'+name+'</td>
	  					<td>'+brand+'</td><td>'+unit+'</td><td class="vweditable" id="edQty'+id+'">'+1+'</td><td class="vweditable" id="edUnit'+id+'">'+1+'</td>
	  					<td class="ecost"id="edCost'+id+'">1</td><td><button class="btn btn-danger 
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

//Document Ready
$(document).ready(function(){

//Verify current password
$('#current-password').blur(function(event) {
	/* Act on the event */
	var val = $(this).val();
	// alert (val);
	$.get('verifyCurrentPassword',{val:val},function(data){
  		if(data == '0'){
  			$('.alert').show();
  		}else{
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
      	  var table=  $('.category').DataTable(); 
	 	  $.post('/addCategory',{ProdCatName:category},function(data){
	 	  	if(data == 0){
	 	  		$('#catError').text('Category already exists!');
      			$('#catError').removeClass('hidden');
	 	  	}else{
	 	  		table.row.add( [
		            data['updated_at'],data['ProdCatName'],'<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
		        ]).draw();
		        var row = table.rows( '.selected' ).indexes();
		        var thisRow= $(row).attr( 'id', 'category'+data['id'] );
		        $(' td:nth-child(1)').attr( 'id', 'catName'+data['id'] );
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
$('#term2,#edTerm2').click(function() {
	$('#termBox,#edTermBox').removeClass('hidden');
	$('#term1,#edTerm1').removeClass('active');
	$('#term,#edTerm').select();
});
$('#term1,#edTerm1').click(function() {
	$('#termBox,#edTermBox').addClass('hidden');
	$('#term2,#edTerm2').removeClass('active');
	$('#term,#edTerm').val(0);
});
$('#term,#edTerm').blur(function() {
	var value=jQuery.trim($(this).val());
	if(value==''){
		$(this).val(0);
	}
});
$("#term,#edTerm").keydown(function(e){
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

	
	
