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
	$("#sidebar-wrapper").hover(function(e) {
	        e.preventDefault();
	        $("#wrapper").addClass("toggled");
	    }, function() {
		$("#wrapper").removeClass('toggled');
	});	
	$('#saveCategory').click(function(e){
			e.preventDefault(); 
	      var category=$('#ProductCategory').val();
	      if((!category) || jQuery.trim(category).length == 0){
	      	$('#catError').text('Category text field is empty!');
	      	$('#catError').removeClass('hidden');
	      }else{
	      	  var table=  $('.category').dataTable(); 
		 	  $.post('/addCategory',{cat:category},function(data){
		 	  	var rowIndex= table.fnAddData([
		               data['id'],data['ProdCatName'],'<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
		        ]);
		      });
	      }
	      $('#ProductCategory').val(' ');
	  
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
	//edit/delete bank
});