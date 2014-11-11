function addPO(e){var t=$("#name"+e).text(),a=$("#brand"+e).text(),r=$("#unit"+e).text(),d=$(".product").DataTable(),o=d.row("#rowProd"+e).index();$(".POtable").append('<tr id="PO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+itemno+'">'+e+"</td>\n		<td>"+t+"</td><td>"+a+"</td><td>"+r+'</td>\n		<td class="light-green editable" id="prodQty'+e+'">1</td><td class="light-red editable" id="prodUnit'+e+'"></td>\n		<td class="cost" id="prodCost'+e+'">0.00</td><td >\n		<button class="btn btn-danger btn-xs square" id="removePO'+itemno+'" onclick="removePO('+itemno+","+e+","+o+')">\n		<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,d.cell(o,4).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw(),$(".editable").editable({send:"never",type:"text",value:1,validate:function(e){return""==$.trim(e)?"This field is required":""==$.isNumeric(e)||0==e?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t),calcCost(e)}}),$("#savePO").removeClass("hidden")}function calcCost(e){var t=$("#prodQty"+e).text(),a=$("#prodUnit"+e).text();$("#prodCost"+e).text(t*a),totalCost()}function totalCost(){var e=0;$(".cost").each(function(){e+=parseInt($(this).text())}),$("#POTotalCost").text(e),(e=0)&&$("#savePO").addClass("hidden")}function removePO(e,t,a){var r=$(".product").DataTable();if(r.cell(a,4).data('<button class="btn btn-success btn-xs square" \n			onclick="addPO('+t+')" >\n			<i class="fa fa-check-circle"></i> Add</button>').draw(),$("#PO"+e).remove(),e+=1,$("#PO"+e).length)for(;itemno>e;)$("#PO"+e).attr("id","PO"+(e-1)),$("#itemno"+e).attr("id","itemno"+(e-1)),$("#itemno"+(e-1)).text(e-1),$("#productId"+e).attr("id","productId"+(e-1)),$("#removePO"+e).attr("id","removePO"+(e-1)),t=$("#productId"+(e-1)).text(),a=r.row("#rowProd"+t).index(),$("#removePO"+(e-1)).attr("onclick","removePO("+(e-1)+","+t+","+a+")"),e++;itemno-=1,totalCost()}function viewPO(e){$("#vwRole").val();$("#viewPOModal").modal("show"),$.post("/viewPO",{id:e},function(e){$("#vwPOId").text(e[0].id),$("#vwPODate").text(e[0].PODate),$("#vwSupplier").val(e[0].SupplierNo),"0"==e[0].Terms?($("#vwTerm").val(0),$("#vwTerm1").addClass("active"),$("#vwTerm1").prop("disabled",!1),$("#vwTerm2").removeClass("active"),$("#vwTerm2").prop("disabled",!0),$("#vwTermBox").addClass("hidden")):($("#vwTerm").val(e[0].Terms),$("#vwTerm1").removeClass("active"),$("#vwTerm1").prop("disabled",!0),$("#vwTerm2").addClass("active"),$("#vwTerm2").prop("disabled",!1),$("#vwTermBox").removeClass("hidden")),$("#vwPreparedBy").val(e[0].PreparedBy),""==e[0].ApprovedBy?$("#vwApprovedBy").val("N/A"):$("#vwApprovedBy").val(e[0].ApprovedBy)}),$.post("/viewPODetails",{id:e},function(e){$(".vwPOTable > tbody").html("");var t=1,a=0;$.each(e,function(e,r){$(".vwPOTable >tbody").append('<tr id="vwPO'+t+'"><td id="vwItemno'+t+'">'+t+"</td><td>"+r.ProductNo+"</td>\n	  					<td>"+r.ProductName+"</td>\n	  					<td>"+r.BrandName+"</td><td>"+r.Unit+"</td><td>"+r.Qty+"</td><td>"+r.CostPerQty+"</td>\n	  					<td>"+r.CostPerQty*r.Qty+'</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+t+'" onclick="vwRemovePO('+t+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),t+=1,a+=r.CostPerQty*r.Qty}),$("#vwTotalCost").text(a)})}function vwRemovePO(e){if($("#vwPO"+e).remove(),e+=1,$("#vwPO"+e).length)for(;$("#vwPO"+e).length;)$("#vwPO"+e).attr("id","vwPO"+(e-1)),$("#vwItemno"+e).attr("id","vwItemno"+(e-1)),$("#vwItemno"+(e-1)).text(e-1),$("#vwRemovePO"+e).attr("id","vwRemovePO"+(e-1)),$("#vwRemovePO"+(e-1)).attr("onclick","vwRemovePO("+(e-1)+")"),e++}function triggerEdit(e){$.get("toEditBank",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.BankName),$(".address").val(a.BAddress),$(".telephone").val(a.Telephone),$(".deactivate").attr("href","/delete-bank/"+e),$(".delete").show()}))}),$("#bank-library").modal("show")}function triggerEditBranch(e){$.get("toEditBranch",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.BranchName),$(".address").val(a.BAddress),$(".telephone").val(a.Telephone),$(".deactivate").attr("href","/delete-branch/"+e),$(".delete").show()}))}),$("#branch-library").modal("show")}function triggerEditCustomer(e){$.get("toEditCustomer",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.CustomerName),$(".address").val(a.Address),$(".telephone1").val(a.Telephone1),$(".telephone2").val(a.Telephone2),$(".contact-person").val(a.ContactPerson),$(".credit-limit").val(a.CreditLimit),$(".deactivate").attr("href","/delete-customer/"+e),$(".delete").show()}))}),$("#customer-library").modal("show")}function triggerEditUser(e){$.get("toEditUser",{id:e},function(t){if(t){$(".alert").remove();var a;$.each(t,function(t,r){1==r.UserType?a="Admin":11==r.UserType?a="Admin/Sales Rep":2==r.UserType?a="Warehouse User":3==r.UserType?a="Office Clerk":4==r.UserType&&(a="Sales Rep"),$("#library-action").val(r.id),$(".username").val(r.username),$(".lastname").val(r.Lastname),$(".firstname").val(r.Firstname),$(".mi").val(r.MI),$(".usertype").val(a),$(".deactivate").attr("href","/delete-user/"+e),$(".delete").show()})}}),$("#user-library").modal("show")}function editCategory(e){$("#modalCatError").addClass("hidden");var t=$(".category").DataTable(),a=jQuery.trim($("#catName"+e).text()),r=t.row("#category"+e).index();$("#catID").val(e),$("#catIndex").val(r),$("#txtCatName").val(a),$("#myModal").modal("show"),$(".modal-title").text("Edit "+a)}function editSupplier(e){$(".supplier").DataTable();$(".modal-title").text("Edit Supplier"),$("#supplierModal").modal("show"),$.post("/fetchSupplier",{id:e},function(e){$("#txtSupID").val(e.id),$("#SupplierName").val(e.SupplierName),$("#Address").val(e.Address),$("#Telephone1").val(e.Telephone1),$("#Telephone2").val(e.Telephone2),$("#ContactPerson").val(e.ContactPerson)})}function editProduct(e){$(".product").DataTable();$(".modal-title").text("Edit Product"),$("#productModal").modal("show"),$.post("/fetchProduct",{id:e},function(e){$("#txtProdID").val(e.id),$("#ProductCatNo").val(e.ProductCatNo),$("#ProductName").val(e.ProductName),$("#BrandName").val(e.BrandName),$("#WholeSaleUnit").val(e.WholeSaleUnit),$("#RetailUnit").val(e.RetailUnit),$("#RetailQtyPerWholeSaleUnit").val(e.RetailQtyPerWholeSaleUnit),$("#Reorderpoint").val(e.Reorderpoint),$("#Markup1").val(e.Markup1),$("#Markup2").val(e.Markup2),$("#Markup3").val(e.Markup3),$("#ActiveMarkup").val(e.ActiveMarkup)})}function numberOnlyInput(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||65==e.keyCode&&e.ctrlKey===!0||e.keyCode>=35&&e.keyCode<=39||(e.shiftKey||e.keyCode<48||e.keyCode>57)&&(e.keyCode<96||e.keyCode>105)&&e.preventDefault()}$(function(){$.ajaxSetup({headers:{"X-CSRF-Token":$('meta[name="_token"]').attr("content")}});var e=window.location.hash;e&&$('ul.nav a[href="'+e+'"]').tab("show")});var itemno=1;$(document).ready(function(){$("#current-password").blur(function(){var e=$(this).val();$.get("verifyCurrentPassword",{val:e},function(e){"0"==e?$(".alert").show():$(".alert").hide()})}),$.fn.editable.defaults.mode="inline",$(".pops").popover({trigger:"hover"}),$(".add-customer").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone1").val(""),$(".telephone2").val(""),$(".contact-person").val(""),$(".credit-limit").val(""),$(".delete").hide()}),$(".add-branch").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone").val(""),$(".delete").hide()}),$(".add-bank").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone").val(""),$(".delete").hide()});var e=document.title;document.getElementsByTagName("body")[0].id=e,$("ul.nav li.dropdown").hover(function(){$(".dropdown-menu",this).fadeIn()},function(){$(".dropdown-menu",this).fadeOut("fast")}),$("#"+e+" a:contains('"+e+"')").parent().addClass("active"),$("#"+e+" a:contains("+e+")").parent().addClass("active"),$(".sidehead ul:contains("+e+")").removeClass("collapse"),$("#sidebar-wrapper").hover(function(e){e.preventDefault(),$("#wrapper").addClass("toggled")},function(){$("#wrapper").removeClass("toggled")}),$("#ProductCategory").keyup(function(){$("#catError").addClass("hidden")}),$("#saveCategory").click(function(e){e.preventDefault();var t=jQuery.trim($("#ProductCategory").val());if(t&&0!=t.length){var a=$(".category").DataTable();$.post("/addCategory",{ProdCatName:t},function(e){if(0==e)$("#catError").text("Category already exists!"),$("#catError").removeClass("hidden");else{a.row.add([e.updated_at,e.ProdCatName,'<button class="btn btn-success btn-xs" onclick="editCategory('+e.id+');"><i class="fa fa-cog"></i> Edit</button>']).draw();{var t=a.rows(".selected").indexes();$(t).attr("id","category"+e.id)}$(" td:nth-child(1)").attr("id","catName"+e.id),$("#catError").addClass("hidden")}})}else $("#catError").text("Category text field is empty!"),$("#catError").removeClass("hidden");$("#ProductCategory").val(" ")}),$("#categoryBtn").click(function(){var e=$(".category").DataTable(),t=$("#catID").val(),a=$("#catIndex").val(),r=$("#txtCatName").val(),d=jQuery.trim($("#txtCatName").val());d&&0!=d.length?$.post("/editCategory",{id:t,ProdCatName:r},function(t){0==t?($("#modalCatError").text("Category already exists!"),$("#modalCatError").removeClass("hidden")):(e.cell(a,1).data(t).draw(),$("#myModal").modal("hide"))}):($("#modalCatError").text("Text field is empty!"),$("#modalCatError").removeClass("hidden"))}),$("#addSupplier").click(function(){$(".modal-title").text("Add new Supplier"),$("#txtSupID").val(null),$("input[type=text]").val(null),$("#supplierModal").modal("show")}),$("#addProduct").click(function(){$(".modal-title").text("Add new Product"),$("#txtProdID").val(null),$("input[type=text]").val(null),$("#productModal").modal("show")}),$(".sidehead").click(function(){$(this).children("ul").first().stop(!0,!0).slideToggle(500)}),$("#telephone,#telephone1,#telephone2").keydown(function(e){e.shiftKey||(e.keyCode<48||e.keyCode>57)&&(e.keyCode<96||e.keyCode>105)?8!=e.keyCode&&9!=e.keyCode&&107!=e.keyCode&&187!=e.keyCode&&116!=e.keyCode&&16!=e.keyCode&&109!=e.keyCode&&189!=e.keyCode&&($(".alert").show(),e.preventDefault()):$(".alert").hide()}),$("#term2,#vwTerm2").click(function(){$("#termBox,#vwTermBox").removeClass("hidden"),$("#term1,#vwTerm1").removeClass("active"),$("#term,#vwTerm").select()}),$("#term1,#vwTerm1").click(function(){$("#termBox,#vwTermBox").addClass("hidden"),$("#term2,#vwTerm2").removeClass("active"),$("#term,#vwTerm").val(0)}),$("#term,#vwTerm").blur(function(){var e=jQuery.trim($(this).val());""==e&&$(this).val(0)}),$("#term,#vwTerm").keydown(function(e){numberOnlyInput(e)}),$("#addProductPO").click(function(){$("#addProductPOModal").modal("show")}),$("#savePO").click(function(){function e(){var e=new Array;return $(".POtable tr").each(function(t,a){e[t]={ProdNo:$(a).find("td:eq(1)").text(),Unit:$(a).find("td:eq(4)").text(),Qty:$(a).find("td:eq(5)").text(),CostPerQty:$(a).find("td:eq(6)").text()}}),e.shift(),e}var t,a=$("#supplier").val(),r=$("#term").val(),d=$("#preparedBy").text();if($("#approved").is(":checked"))var o=d;else var o="";t=e(),t=$.toJSON(t),$.post("/savePO",{TD:t,supplier:a,term:r,preparedBy:d,approvedBy:o},function(){(date=1)?(location.reload(),$("#successModal").modal("show")):$("#errorModal").modal("show")})})});