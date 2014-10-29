function triggerEdit(e){$.get("toEditBank",{id:e},function(t){t&&($(".alert").remove(),$(".bankForm div").find("div").remove().end(),$.each(t,function(t,r){$(".bankForm div").append('\n			<form method="GET" action="http://qualimeds.com/banks/'+e+'/edit" accept-charset="UTF-8" id="bankForm">			<div class="form-group">				<input class="form-control name" type="text" name="name" value="'+r.BankName+'" required>			</div>			<div class="form-group">				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+r.BAddress+'</textarea>			</div>			<div class="form-group">				<input class="form-control telephone" type="text" name="telephone" id="telephone" value="'+r.Telephone+'" required>				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>			</div>			<div class="form-group">				<center>					<button class="btn btn-primary action" type="submit">Update</button>					<a href="/delete-bank/'+e+'"><button class="btn btn-danger" type="button" id="bank-delete">Delete</button></a>					<br>					<br>					<hr class="style-fade">\n					<i>or</i>\n				</center>				<center>					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Bank</button>				</center>	\n			</div>	\n			')}))})}function triggerEditBranch(e){$.get("toEditBranch",{id:e},function(t){t&&($(".alert").remove(),$(".branchForm div").find("div").remove().end(),$.each(t,function(t,r){$(".branchForm div").append('\n			<form method="GET" action="http://qualimeds.com/branches/'+e+'/edit" accept-charset="UTF-8">			<div class="form-group">				<input class="form-control name" type="text" name="name" value="'+r.BranchName+'" required>			</div>			<div class="form-group">				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+r.BAddress+'</textarea>			</div>			<div class="form-group">				<input class="form-control telephone" type="text" name="telephone" id="telephone" value="'+r.Telephone+'" required>				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>			</div>			<div class="form-group">				<center>					<button class="btn btn-primary action" type="submit">Update</button>					<a href="/delete-branch/'+e+'"><button class="btn btn-danger" type="button" id="bank-delete">Delete</button></a>					<br>					<br>					<hr class="style-fade">\n					<i>or</i>\n				</center>				<center>					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Branch</button>				</center>	\n			</div>	\n			')}))})}function triggerEditCustomer(e){$.get("toEditCustomer",{id:e},function(t){t&&($(".alert").remove(),$(".customerForm div").find("div").remove().end(),$.each(t,function(t,r){$(".customerForm div").append('\n			<form method="GET" action="http://qualimeds.com/customers/'+e+'/edit" accept-charset="UTF-8">			<div class="form-group">				<input class="form-control name" type="text" name="name" value="'+r.CustomerName+'" required>			</div>			<div class="form-group">				<textarea class="form-control address" rows="3" type="textarea" name="address" required>'+r.Address+'</textarea>			</div>			<div class="form-group">				<input class="form-control telephone1" type="text" name="telephone1" id="telephone1" value="'+r.Telephone1+'" required>				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>			</div>			<div class="form-group">				<input class="form-control telephone2" type="text" name="telephone2" id="telephone2" value="'+r.Telephone2+'">				<div class="alert alert-danger" role="alert" hidden>Phone Format Only. i.e. +63-916-1111-455</div>			</div>			<div class="form-group">				<input class="form-control contact-person" type="text" name="contact-person" id="contact-person" value="'+r.ContactPerson+'" required>			</div>			<div class="form-group">				<input class="form-control credit-limit type="text" name="credit-limit" id="contact-person" value="'+r.CreditLimit+'" required>			</div>			<div class="form-group">				<center>					<button class="btn btn-primary action" type="submit">Update</button>					<a href="/delete-customer/'+e+'"><button class="btn btn-danger" type="button" id="customer-delete">Delete</button></a>					<br>					<br>					<hr class="style-fade">\n					<i>or</i>\n				</center>				<center>					<button type="button" class="btn btn-success" onClick="window.location.reload()">Add New Customer</button>				</center>	\n			</div>	\n			')}))})}$(function(){$.ajaxSetup({headers:{"X-CSRF-Token":$('meta[name="_token"]').attr("content")}})}),$(document).ready(function(){$("#sidebar-wrapper").hover(function(e){e.preventDefault(),$("#wrapper").addClass("toggled")},function(){$("#wrapper").removeClass("toggled")}),$("#saveCategory").click(function(e){e.preventDefault();var t=$("#ProductCategory").val();if(t&&0!=jQuery.trim(t).length){var r=$(".category").dataTable();$.post("/addCategory",{cat:t},function(e){r.fnAddData([e.id,e.ProdCatName,'<button class="btn btn-success btn-xs" onclick="editCategory('+e.id+');"><i class="fa fa-cog"></i> Edit</button>'])})}else $("#catError").text("Category text field is empty!"),$("#catError").removeClass("hidden");$("#ProductCategory").val(" ")}),$(".sidehead").click(function(){$(this).children("ul").first().stop(!0,!0).slideToggle(500)}),$("#telephone,#telephone1,#telephone2").keydown(function(e){e.shiftKey||(e.keyCode<48||e.keyCode>57)&&(e.keyCode<96||e.keyCode>105)?8!=e.keyCode&&107!=e.keyCode&&187!=e.keyCode&&116!=e.keyCode&&16!=e.keyCode&&109!=e.keyCode&&189!=e.keyCode&&($(".alert").show(),e.preventDefault()):$(".alert").hide()})});