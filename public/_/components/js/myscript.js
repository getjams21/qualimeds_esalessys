$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
});
//edit-delte bank
function triggerEdit(id){
	$.get('toEditBank',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$('.bankForm div')
			.find('div')
			.remove()
			.end();
  			$.each(data, function(key,value) {
  				$('.bankForm div')
  				.append('
			<form method="GET" action="http://qualimeds.com/banks/'+id+'/edit" accept-charset="UTF-8" id="bankForm">\
			<div class="form-group">\
				<input class="form-control name" type="text" name="name" value="'+value.BankName+'" required>\
			</div>\
			<div class="form-group">\
				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+value.BAddress+'</textarea>\
			</div>\
			<div class="form-group">\
				<input class="form-control telephone" type="text" name="telephone" id="telephone" value="'+value.Telephone+'" required>\
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>\
			</div>\
			<div class="form-group">\
				<center>\
					<button class="btn btn-primary action" type="submit">Update</button>\
					<a href="/delete-bank/'+id+'"><button class="btn btn-danger" type="button" id="bank-delete">Delete</button></a>\
					<br>\
					<br>\
					<hr class="style-fade">
					<i>or</i>
				</center>\
				<center>\
					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Bank</button>\
				</center>	
			</div>	
			');
			});
  		}
  	});
}
//edit-delete branch
function triggerEditBranch(id){
	$.get('toEditBranch',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$('.branchForm div')
			.find('div')
			.remove()
			.end();
  			$.each(data, function(key,value) {
  				$('.branchForm div')
  				.append('
			<form method="GET" action="http://qualimeds.com/branches/'+id+'/edit" accept-charset="UTF-8">\
			<div class="form-group">\
				<input class="form-control name" type="text" name="name" value="'+value.BranchName+'" required>\
			</div>\
			<div class="form-group">\
				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+value.BAddress+'</textarea>\
			</div>\
			<div class="form-group">\
				<input class="form-control telephone" type="text" name="telephone" id="telephone" value="'+value.Telephone+'" required>\
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>\
			</div>\
			<div class="form-group">\
				<center>\
					<button class="btn btn-primary action" type="submit">Update</button>\
					<a href="/delete-branch/'+id+'"><button class="btn btn-danger" type="button" id="bank-delete">Delete</button></a>\
					<br>\
					<br>\
					<hr class="style-fade">
					<i>or</i>
				</center>\
				<center>\
					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Branch</button>\
				</center>	
			</div>	
			');
			});
  		}
  	});
}
//edit-delete branch
function triggerEditCustomer(id){
	$.get('toEditCustomer',{id:id},function(data){
  		if(data){
  			$('.alert').remove();
  			$('.customerForm div')
			.find('div')
			.remove()
			.end();
  			$.each(data, function(key,value) {
  				$('.customerForm div')
  				.append('
			<form method="GET" action="http://qualimeds.com/customers/'+id+'/edit" accept-charset="UTF-8">\
			<div class="form-group">\
				<input class="form-control name" type="text" name="name" value="'+value.CustomerName+'" required>\
			</div>\
			<div class="form-group">\
				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+value.Address+'</textarea>\
			</div>\
			<div class="form-group">\
				<input class="form-control telephone1" type="text" name="telephone1" id="telephone1" value="'+value.Telephone1+'" required>\
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>\
			</div>\
			<div class="form-group">\
				<input class="form-control telephone2" type="text" name="telephone2" id="telephone2" value="'+value.Telephone2+'">\
				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>\
			</div>\
			<div class="form-group">\
				<input class="form-control contact-person" type="text" name="contact-person" id="contact-person" value="'+value.ContactPerson+'" required>\
			</div>\
			<div class="form-group">\
				<input class="form-control credit-limit type="text" name="credit-limit" id="contact-person" value="'+value.CreditLimit+'" required>\
			</div>\
			<div class="form-group">\
				<center>\
					<button class="btn btn-primary action" type="submit">Update</button>\
					<a href="/delete-customer/'+id+'"><button class="btn btn-danger" type="button" id="customer-delete">Delete</button></a>\
					<br>\
					<br>\
					<hr class="style-fade">
					<i>or</i>
				</center>\
				<center>\
					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Customer</button>\
				</center>	
			</div>	
			');
			});
  		}
  	});
}
$(document).ready(function(){
		
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
		 	  $.post('/addCategory',{cat:category},function(data){
		 	  	if(data == 0){
		 	  		$('#catError').text('Category already exists!');
	      			$('#catError').removeClass('hidden');
		 	  	}else{
			 	  	var rowIndex= table.fnAddData([
			               data['id'],data['ProdCatName'],'<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
			        ]);
			        var row = table.fnGetNodes(rowIndex);
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
	var catName = $('#txtCatName').val();
	var category=jQuery.trim($('#txtCatName').val());
      if((!category) || category.length == 0){
      	$('#modalCatError').text('Text field is empty!');
      	$('#modalCatError').removeClass('hidden');
      }else{
      		$.post('/editCategory',{id:id,catName:catName},function(data){
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
                if(event.keyCode != 8 && event.keyCode != 107 && event.keyCode != 187 && event.keyCode != 116 && event.keyCode != 16 && event.keyCode != 109 && event.keyCode != 189){
                	$('.alert').show();
                	event.preventDefault();
                }
            }
        else{
        	$('.alert').hide();
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

	
	
