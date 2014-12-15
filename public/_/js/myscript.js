function addPO(e){$.post("/addProductToPO",{id:e},function(t){$("#productId"+e).length?$("#prodError1").fadeIn("fast",function(){$("#prodError1").fadeOut(4e3)}):($(".POtable").append('<tr id="PO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+e+'">'+e+"</td>\n						<td>"+t.ProductName+"</td><td>"+t.BrandName+"</td><td>"+t.WholeSaleUnit+'</td>\n						<td class="light-green editable dp" id="prodQty'+e+'">'+money(1)+'</td><td class="light-red editable dp" id="prodUnit'+e+'">1.00</td>\n						<td class="cost dp" id="prodCost'+e+'">0.00</td><td >\n						<button class="btn btn-danger btn-xs square" id="removePO'+itemno+'" onclick="removePO('+itemno+')">\n						<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,$(".editable").editable({send:"never",type:"text",value:1,validate:function(e){return""==$.trim(e)?"This field is required":""==$.isNumeric(e)||0==e?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(money(t)),calcCost(e)}}),$("#savePO").removeClass("hidden"))})}function calcCost(e){var t=$("#prodQty"+e).text(),a=$("#prodUnit"+e).text();$("#prodCost"+e).text(money(t*a)),totalCost()}function totalCost(){var e=0;$(".cost").each(function(){e+=parseFloat($(this).text())}),$("#POTotalCost").text(money(e)),(e=0)&&$("#savePO").addClass("hidden")}function removePO(e){if($("#PO"+e).remove(),e+=1,$("#PO"+e).length)for(;itemno>e;)$("#PO"+e).attr("id","PO"+(e-1)),$("#itemno"+e).attr("id","itemno"+(e-1)),$("#itemno"+(e-1)).text(e-1),$("#removePO"+e).attr("id","removePO"+(e-1)),$("#removePO"+(e-1)).attr("onclick","removePO("+(e-1)+")"),e++;itemno-=1,totalCost()}function viewPO(e){$("#viewPOModal").modal("show"),$.post("/viewPO",{id:e},function(e){$("#vwPOId").text(e[0].id),$("#vwPODate").text(e[0].PODate),$("#vwSupplier").val(e[0].SupplierNo),"0"==e[0].Terms?$("#vwTerm").val("Cash"):$("#vwTerm").val(e[0].Terms),$("#vwPreparedBy").val(e[0].PreparedBy),""==e[0].ApprovedBy?$("#vwApprovedBy").val("N/A"):$("#vwApprovedBy").val(e[0].ApprovedBy),$("#vwCancelMsg").attr("class","alert"),1==e[0].IsCancelled?($("#vwCancelMsg").addClass("alert-danger"),$("#vwCancelMsg").text("This PO has been cancelled by "+e[0].CancelledBy)):""!=e[0].ApprovedBy&&($("#vwCancelMsg").addClass("alert-success"),$("#vwCancelMsg").text("This PO has been approved by "+e[0].ApprovedBy))}),$.post("/viewPODetails",{id:e},function(e){$(".vwPOTable > tbody").html(""),counter=1;var t=0;$.each(e,function(e,a){$(".vwPOTable >tbody").append("<tr ><td>"+counter+"</td><td>"+a.ProductNo+"</td>\n	  					<td>"+a.ProductName+"</td>\n	  					<td>"+a.BrandName+"</td><td >"+a.Unit+'</td><td class="dp">'+Number(a.Qty).toFixed(0)+'</td><td class="dp">'+Number(a.CostPerQty).toFixed(2)+'</td>\n	  					<td class="dp">'+a.CostPerQty*a.Qty+"</td></tr>"),counter+=1,t+=a.CostPerQty*a.Qty}),$("#vwTotalCost").text(Number(t).toFixed(2))})}function editPO(e){$("#vwSavePOBtn").addClass("hidden"),$("#editPOModal").modal("show"),$.post("/viewPO",{id:e},function(e){$("#edPOId").text(e[0].id),$("#edPODate").text(e[0].PODate),$('[name="vwSupplier"]').val(e[0].SupplierNo),"0"==e[0].Terms?($("#edTerm").val(0),$("#edTerm1").addClass("active"),$("#edTerm2").removeClass("active"),$("#edTermBox").addClass("hidden")):($("#edTerm").val(e[0].Terms),$("#edTerm1").removeClass("active"),$("#edTerm2").addClass("active"),$("#edTerm2").prop("disabled",!1),$("#edTermBox").removeClass("hidden")),$("#edPreparedBy").val(e[0].PreparedBy),""==e[0].ApprovedBy?($("#edApprovedBy").val("N/A"),$("#vwApproved").prop("checked",!1)):($("#edApprovedBy").val(e[0].ApprovedBy),$("#vwApproved").prop("checked",!0),"Bills"==document.title&&$("#vwApproved").prop("disabled",!0))}),$.post("/viewPODetails",{id:e},function(e){$(".edPOTable > tbody").html(""),counter=1;var t=0;$.each(e,function(e,a){$(".edPOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+a.ProductNo+'">'+a.ProductNo+"</td>\n	  					<td>"+a.ProductName+"</td>\n	  					<td>"+a.BrandName+"</td><td>"+a.Unit+'</td><td class="vweditable dp" id="edQty'+a.ProductNo+'">'+a.Qty+'</td><td class="vweditable dp" id="edUnit'+a.ProductNo+'">'+Number(a.CostPerQty).toFixed(2)+'</td>\n	  					<td class="ecost dp"id="edCost'+a.ProductNo+'">'+Number(a.CostPerQty).toFixed(2)+'</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),t+=a.CostPerQty*a.Qty,editable(a.ProductNo),counter+=1}),$("#edPOTotalCost").text(Number(t).toFixed(2))})}function billPO(e){$("#saveBillPOBtn,#billApprove").removeClass("hidden"),$("#vwSaveBillBtn,#BillCancelBtn,#checkAlert,#billApproved").addClass("hidden"),$("#billNo").text("New Bill"),$("#billPOModal").modal("show"),$.post("/viewPO",{id:e},function(e){$("#billPOId").text(e[0].id),$('[name="billPOSupplier"]').val(e[0].SupplierNo),$("#billBranchName").val(e[0].BranchName),"0"==e[0].Terms?($("#billTerm").val(0),$("#billTerm1").addClass("active"),$("#billTerm2").removeClass("active"),$("#billTermBox").addClass("hidden")):($("#billTerm").val(e[0].Terms),$("#billTerm1").removeClass("active"),$("#billTerm2").addClass("active"),$("#billTerm2").prop("disabled",!1),$("#billTermBox").removeClass("hidden"))}),$.post("/viewPODetails",{id:e},function(e){$(".BillPOTable > tbody").html(""),counter=1;var t=0;$.each(e,function(e,a){$(".BillPOTable >tbody").append('<tr id="billPO'+counter+'" class="billRow"><td >'+counter+"</td><td>"+a.ProductNo+"</td>\n	  					<td>"+a.ProductName+"</td>\n	  					<td>"+a.BrandName+"</td><td>"+a.Unit+'</td><td class="numberEditable danger"></td><td class="danger dateEditable">'+(d.getFullYear()+1)+'-01-01</td><td class="dp" >'+a.Qty+'</td><td class="dp" >'+Number(a.CostPerQty).toFixed(2)+'</td>\n	  					<td class="dp success">'+Number(a.CostPerQty*a.Qty).toFixed(2)+'</td><td class="vweditable dp danger">0</td><td class="danger selectEditable dp"></td></tr>'),t+=a.CostPerQty*a.Qty,editable(a.ProductNo),editableNumber(a.ProductNo),editableSelect(a.ProductNo,a.RetailUnit,a.WholeSaleUnit),dateEditable(a.ProductNo),counter+=1}),$("#billPOTotalCost").text(Number(t).toFixed(2))})}function editBill(e){$("#saveBillPOBtn,#vwSaveBillBtn,#billApprove").addClass("hidden"),$("#BillCancelBtn,#checkAlert,#billApproved,#vwSaveBillBtn").removeClass("hidden"),$("#vwSaveBillBtn").val(e),$("#billPOModal").modal("show"),$("#billNo").text("Bill No. "+e),$.post("/viewBill",{id:e},function(e){$("#billPOId").text(e[0].PurchaseOrderNo),$('[name="billPOSupplier"]').val(e[0].SupplierNo),$("#billBranchName").val(e[0].BranchName),"0"==e[0].Terms?($("#billTerm").val(0),$("#billTerm1").addClass("active"),$("#billTerm2").removeClass("active"),$("#billTermBox").addClass("hidden")):($("#billTerm").val(e[0].Terms),$("#billTerm1").removeClass("active"),$("#billTerm2").addClass("active"),$("#billTerm2").prop("disabled",!1),$("#billTermBox").removeClass("hidden")),""==e[0].ApprovedBy?$("#billApproved").prop("checked",!1):$("#billApproved").prop("checked",!0);var t=new Date(e[0].SalesInvoiceDate);$("#invoicedate").val(t.getMonth()+1+"/"+t.getDate()+"/"+t.getFullYear()),$("#invoiceno").val(e[0].SalesInvoiceNo)}),$.post("/viewBillDetails",{id:e},function(e){$(".BillPOTable > tbody").html(""),counter=1;var t=0;$.each(e,function(e,a){$(".BillPOTable >tbody").append('<tr id="billPO'+counter+'" ><td >'+counter+"</td><td>"+a.ProductNo+"</td>\n	  					<td>"+a.ProductName+"</td>\n	  					<td>"+a.BrandName+"</td><td>"+a.Unit+'</td><td class="numberEditable danger">'+a.LotNo+'</td><td class="danger dateEditable">'+a.ExpiryDate+'</td><td class="dp" >'+a.Qty+'</td><td class="dp" >'+Number(a.Cost).toFixed(2)+'</td>\n	  					<td class="dp success">'+Number(a.Cost*a.Qty).toFixed(2)+'</td><td class="vweditable dp danger">'+a.FreebiesQty+'</td><td class="danger selectEditable dp">'+a.FreebiesUnit+"</td></tr>"),t+=a.Cost*a.Qty,editable(a.ProductNo),editableNumber(a.ProductNo),editableSelect(a.ProductNo,a.RetailUnit,a.WholeSaleUnit),dateEditable(a.ProductNo),counter+=1}),$("#billPOTotalCost").text(Number(t).toFixed(2))})}function viewBill(e){$("#viewBillModal").modal("show"),$("#vwbillNo").text(e),$.post("/viewBill",{id:e},function(e){$("#vwbillPOId").text(e[0].PurchaseOrderNo),$('[name="vwBillSupplier"]').val(e[0].SupplierNo),$("#vwBillBranchName").val(e[0].BranchName),"0"==e[0].Terms?$("#vwBillTerm").val("Cash"):$("#vwBillTerm").val(e[0].Terms),$("#billDate").text(e[0].BillDate);var t=new Date(e[0].SalesInvoiceDate);$("#vwBillInvoiceDate").val(t.getMonth()+1+"/"+t.getDate()+"/"+t.getFullYear()),$("#vwBillInvoiceNo").val(e[0].SalesInvoiceNo)}),$.post("/viewBillDetails",{id:e},function(e){$(".BillPOTable2 > tbody").html(""),counter=1;var t=0;$.each(e,function(e,a){$(".BillPOTable2 >tbody").append("<tr ><td >"+counter+"</td><td>"+a.ProductNo+"</td>\n	  					<td>"+a.ProductName+"</td>\n	  					<td>"+a.BrandName+"</td><td>"+a.Unit+"</td><td >"+a.LotNo+"</td><td >"+a.ExpiryDate+'</td><td class="dp" >'+a.Qty+'</td><td class="dp" >'+Number(a.Cost).toFixed(2)+'</td>\n	  					<td class="dp success">'+Number(a.Cost*a.Qty).toFixed(2)+'</td><td class="dp ">'+a.FreebiesQty+'</td><td class="dp">'+a.FreebiesUnit+"</td></tr>"),t+=a.Cost*a.Qty,counter+=1}),$("#vwBillTotalCost").text(Number(t).toFixed(2))})}function editable(e){$(".vweditable").editable({send:"never",type:"text",validate:function(e){return""==$.trim(e)?"This field is required":""==$.isNumeric(e)||0==e?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(Number(t).toFixed(2)),edcalcCost(e)}})}function editableNumber(){$(".numberEditable").editable({send:"never",type:"text",emptytext:0,validate:function(e){return""==$.trim(e)?"This field is required":""==$.isNumeric(e)||0==e?"Please input a valid number greater than 0":void 0},display:function(e){$(this).text(e)}})}function editableSelect(e,t,a){$(".selectEditable").editable({value:1,type:"select",validate:function(e){return""==$.trim(e)?"This field is required":void 0},source:[{value:1,text:t},{value:2,text:a}]})}function dateEditable(){$(".dateEditable").editable({type:"combodate",format:"YYYY-MM-DD",viewformat:"YYYY-MM-DD",template:"D / MMMM / YYYY",validate:function(e){return""==$.trim(e)?"This field is required":void 0},combodate:{minYear:d.getFullYear(),maxYear:d.getFullYear()+10,minuteStep:1}})}function edcalcCost(e){var t=$("#edQty"+e).text(),a=$("#edUnit"+e).text();$("#edCost"+e).text(Number(t*a).toFixed(2)),edtotalCost()}function edtotalCost(){var e=0;$(".ecost").each(function(){e+=parseFloat($(this).text())}),$("#edPOTotalCost").text(Number(e).toFixed(2)),0==e&&$("#vwSavePOBtn").addClass("hidden")}function vwaddPO(e){{var t=$("#vwname"+e).text(),a=$("#vwbrand"+e).text(),d=$("#vwunit"+e).text(),l=$(".vwproduct").DataTable();l.row("#vwrowProd"+e).index()}$("#vwProd"+e).length?$("#prodError").fadeIn("fast",function(){$("#prodError").fadeOut(4e3)}):($(".edPOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+e+'">'+e+"</td>\n	  					<td>"+t+"</td>\n	  					<td>"+a+"</td><td>"+d+'</td><td class="vweditable dp" id="edQty'+e+'">'+Number(1).toFixed(2)+'</td><td class="vweditable dp" id="edUnit'+e+'">'+Number(1).toFixed(2)+'</td>\n	  					<td class="ecost dp"id="edCost'+e+'">0.00</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),counter+=1,editable(e),$("#vwSavePOBtn").removeClass("hidden"))}function vwRemovePO(e){if($("#vwPO"+e).remove(),e+=1,$("#vwPO"+e).length)for(;$("#vwPO"+e).length;)$("#vwPO"+e).attr("id","vwPO"+(e-1)),$("#vwItemno"+e).attr("id","vwItemno"+(e-1)),$("#vwItemno"+(e-1)).text(e-1),$("#vwRemovePO"+e).attr("id","vwRemovePO"+(e-1)),$("#vwRemovePO"+(e-1)).attr("onclick","vwRemovePO("+(e-1)+")"),e++;counter-=1,edtotalCost(),$("#vwSavePOBtn").removeClass("hidden")}function triggerEdit(e){$.get("toEditBank",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.BankName),$(".address").val(a.BAddress),$(".telephone").val(a.Telephone),$(".deactivate").attr("href","/delete-bank/"+e),$(".delete").show()}))}),$("#bank-library").modal("show")}function triggerEditBranch(e){$.get("toEditBranch",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.BranchName),$(".address").val(a.BAddress),$(".telephone").val(a.Telephone),$(".deactivate").attr("href","/delete-branch/"+e),$(".delete").show()}))}),$("#branch-library").modal("show")}function triggerEditCustomer(e){$.get("toEditCustomer",{id:e},function(t){t&&($(".alert").remove(),$.each(t,function(t,a){$("#library-action").val(a.id),$(".name").val(a.CustomerName),$(".address").val(a.Address),$(".telephone1").val(a.Telephone1),$(".telephone2").val(a.Telephone2),$(".contact-person").val(a.ContactPerson),$(".credit-limit").val(a.CreditLimit),$(".deactivate").attr("href","/delete-customer/"+e),$(".delete").show()}))}),$("#customer-library").modal("show")}function triggerEditUser(e){$.get("toEditUser",{id:e},function(t){if(t){$(".alert").remove();var a;$.each(t,function(t,d){$('select#usertype option[value="'+d.UserType+'"]').attr("selected",!0),$('select#branches option[value="'+d.BranchNo+'"]').attr("selected",!0),$("#library-action").val(d.id),$(".username").val(d.username),$(".lastname").val(d.Lastname),$(".firstname").val(d.Firstname),$(".mi").val(d.MI),$(".usertype").val(a),$(".deactivate").attr("href","/delete-user/"+e),$(".delete").show()})}}),$(".user-pwd").hide(),$(".password,.retype-password").removeAttr("required"),$("#user-library").modal("show")}function money(e){return Number(e).toFixed(2)}function numberWithCommas(e){var t=e.toString().split(".");return t[0]=t[0].replace(/\B(?=(\d{3})+(?!\d))/g,","),t.join(".")}function addBillToPayment(e){$.post("/addBillToPayment",{id:e},function(t){if($("#billId"+e).length)$("#billError1").fadeIn("fast",function(){$("#billError1").fadeOut(4e3)});else{if($("#bill1").length&&!$(".supplier"+t[0].SupplierNo).length)return $("#billSupError1").fadeIn("fast",function(){$("#billSupError1").fadeOut(4e3)}),void 0;$(".BillPaymentTable").append('<tr id="bill'+itemno+'"><td id="billitemno'+itemno+'">'+itemno+'</td><td id="billId'+e+'">'+e+'</td>\n							<td class="supplier'+t[0].SupplierNo+'">'+t[0].SupplierName+'<td class="dp">'+t[0].SalesInvoiceNo+'</td><td class="dp Billcost">'+money(t.amount)+'</td><td>\n							<button class="btn btn-danger btn-xs square" id="removeBill'+itemno+'" onclick="removeBill('+itemno+')">\n							<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,calcBillPaymentTotal(),$("#saveBill,.cashChecque").removeClass("hidden")}})}function removeBill(e){if($("#bill"+e).remove(),e+=1,$("#bill"+e).length)for(;itemno>e;)$("#bill"+e).attr("id","bill"+(e-1)),$("#billitemno"+e).attr("id","itemno"+(e-1)),$("#billitemno"+(e-1)).text(e-1),$("#removeBill"+e).attr("id","removeBill"+(e-1)),$("#removeBill"+(e-1)).attr("onclick","removeBill("+(e-1)+")"),e++;itemno-=1,calcBillPaymentTotal()}function calcBillPaymentTotal(){var e=0;$(".Billcost").each(function(){e+=parseFloat($(this).text())}),$("#BillPaymentTotalCost").text(money(e)),0==e&&$("#saveBill,.cashChecque").addClass("hidden")}function editCategory(e){$("#modalCatError").addClass("hidden");var t=$(".category").DataTable(),a=jQuery.trim($("#catName"+e).text()),d=t.row("#category"+e).index();$("#catID").val(e),$("#catIndex").val(d),$("#txtCatName").val(a),$("#myModal").modal("show"),$(".modal-title").text("Edit "+a)}function editSupplier(e){$(".supplier").DataTable();$(".modal-title").text("Edit Supplier"),$("#supplierModal").modal("show"),$.post("/fetchSupplier",{id:e},function(e){$("#txtSupID").val(e.id),$("#SupplierName").val(e.SupplierName),$("#Address").val(e.Address),$("#Telephone1").val(e.Telephone1),$("#Telephone2").val(e.Telephone2),$("#ContactPerson").val(e.ContactPerson)})}function editProduct(e){$(".product").DataTable();$(".modal-title").text("Edit Product"),$("#productModal").modal("show"),$.post("/fetchProduct",{id:e},function(e){$("#txtProdID").val(e.id),$("#ProductCatNo").val(e.ProductCatNo),$("#ProductName").val(e.ProductName),$("#BrandName").val(e.BrandName),$("#WholeSaleUnit").val(e.WholeSaleUnit),$("#RetailUnit").val(e.RetailUnit),$("#RetailQtyPerWholeSaleUnit").val(e.RetailQtyPerWholeSaleUnit),$("#Reorderpoint").val(e.Reorderpoint),$("#Markup1").val(e.Markup1),$("#Markup2").val(e.Markup2),$("#Markup3").val(e.Markup3),$("#ActiveMarkup").val(e.ActiveMarkup)})}function numberOnlyInput(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||65==e.keyCode&&e.ctrlKey===!0||e.keyCode>=35&&e.keyCode<=39||(e.shiftKey||e.keyCode<48||e.keyCode>57)&&(e.keyCode<96||e.keyCode>105)&&e.preventDefault()}$(function(){$.ajaxSetup({headers:{"X-CSRF-Token":$('meta[name="_token"]').attr("content")}});var e=window.location.hash;e&&$('ul.nav a[href="'+e+'"]').tab("show")});var itemno=1,counter=1,d=new Date;$(document).ready(function(){$(".add-user").click(function(){$('#userForm input[type="text"]').val("")}),$("#user-library").on("hidden.bs.modal",function(){$(".user-pwd,.password,.retype-password").show(),$(".password,.retype-password").attr("required")}),$("#invoiceDate").datepicker(),$("#edTerm,#vwSupplier").change(function(){$("#vwSavePOBtn").removeClass("hidden")}),$("#edTerm1").click(function(){$("#vwSavePOBtn").removeClass("hidden")}),$("#vwApproved").change(function(){var e=$("#edPOId").text();if($("#vwApproved").is(":checked"))var t=1;else var t=0;$.post("/approvePO",{id:e,ApprovedBy:t},function(t){t?($("#edApprovedBy").val(t),$("#App"+e).text(t),$("#App"+e).parent("tr").removeClass("warning"),$("#App"+e).parent("tr").addClass("success")):($("#edApprovedBy").val("N/A"),$("#App"+e).text("N/A"),$("#App"+e).parent("tr").removeClass("success"),$("#App"+e).parent("tr").addClass("warning"))})}),$("#billApproved").change(function(){var e=$("#vwSaveBillBtn").val();if($("#billApproved").is(":checked"))var t=1;else var t=0;$.post("/approveBill",{id:e,ApprovedBy:t},function(t){t?($("#App"+e).text(t),$("#App"+e).parent("tr").removeClass("warning"),$("#App"+e).parent("tr").addClass("success")):($("#App"+e).text("N/A"),$("#App"+e).parent("tr").removeClass("success"),$("#App"+e).parent("tr").addClass("warning"))})}),$("#POCancelBtn").click(function(){var e=$("#edPOId").text();$.post("/cancelPO",{id:e},function(t){$("#CancelledBy"+e).text(t),location.reload(),"Purchase"==document.title&&$(location).attr("href","/PurchaseOrders#showPOList")})}),$("#BillCancelBtn").click(function(){var e=$("#vwSaveBillBtn").val();alert(e),$.post("/cancelBill",{id:e},function(){location.reload(),"Bills"==document.title&&$(location).attr("href","/Bills#BillsList")})}),$("#current-password").blur(function(){var e=$(this).val();$.get("verifyCurrentPassword",{val:e},function(e){"0"==e?($("#isCurrentPW").val("0"),$(".alert").show()):($("#isCurrentPW").val("1"),$(".alert").hide())})}),$.fn.editable.defaults.mode="inline",$(".pops").popover({trigger:"hover"}),$(".add-customer").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone1").val(""),$(".telephone2").val(""),$(".contact-person").val(""),$(".credit-limit").val(""),$(".delete").hide()}),$(".add-branch").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone").val(""),$(".delete").hide()}),$(".add-bank").click(function(){$("#library-action").val(""),$(".name").val(""),$(".address").val(""),$(".telephone").val(""),$(".delete").hide()});var e=document.title;document.getElementsByTagName("body")[0].id=e,$("ul.nav li.dropdown").hover(function(){$(".dropdown-menu",this).fadeIn()},function(){$(".dropdown-menu",this).fadeOut("fast")}),$("#"+e+" a:contains('"+e+"')").parent().addClass("active"),$("#"+e+" a:contains("+e+")").parent().addClass("active"),$(".sidehead ul:contains("+e+")").removeClass("collapse"),$("#sidebar-wrapper").hover(function(e){e.preventDefault(),$("#wrapper").addClass("toggled")},function(){$("#wrapper").removeClass("toggled")}),$("#ProductCategory").keyup(function(){$("#catError").addClass("hidden")}),$("#saveCategory").click(function(e){e.preventDefault();var t=jQuery.trim($("#ProductCategory").val());if(t&&0!=t.length){var a=$(".category").dataTable();$.post("/addCategory",{ProdCatName:t},function(e){if(0==e)$("#catError").text("Category already exists!"),$("#catError").removeClass("hidden");else{var t=a.fnAddData([e.updated_at,e.ProdCatName,'<button class="btn btn-success btn-xs" onclick="editCategory('+e.id+');"><i class="fa fa-cog"></i> Edit</button>']),d=a.fnSettings().aoData[t[0]].nTr;d.setAttribute("id","category"+e.id),$("#category"+e.id+" td:nth-child(1)").attr("id","catName"+e.id),$("#catError").addClass("hidden")}})}else $("#catError").text("Category text field is empty!"),$("#catError").removeClass("hidden");$("#ProductCategory").val(" ")}),$("#categoryBtn").click(function(){var e=$(".category").DataTable(),t=$("#catID").val(),a=$("#catIndex").val(),d=$("#txtCatName").val(),l=jQuery.trim($("#txtCatName").val());l&&0!=l.length?$.post("/editCategory",{id:t,ProdCatName:d},function(t){0==t?($("#modalCatError").text("Category already exists!"),$("#modalCatError").removeClass("hidden")):(e.cell(a,1).data(t).draw(),$("#myModal").modal("hide"))}):($("#modalCatError").text("Text field is empty!"),$("#modalCatError").removeClass("hidden"))}),$("#addSupplier").click(function(){$(".modal-title").text("Add new Supplier"),$("#txtSupID").val(null),$("input[type=text]").val(null),$("#supplierModal").modal("show")}),$("#addProduct").click(function(){$(".modal-title").text("Add new Product"),$("#txtProdID").val(null),$("input[type=text]").val(null),$("#productModal").modal("show")}),$(".sidehead").click(function(){$(this).children("ul").first().stop(!0,!0).slideToggle(500)}),$("#telephone,#telephone1,#telephone2").keydown(function(e){e.shiftKey||(e.keyCode<48||e.keyCode>57)&&(e.keyCode<96||e.keyCode>105)?8!=e.keyCode&&9!=e.keyCode&&107!=e.keyCode&&187!=e.keyCode&&116!=e.keyCode&&16!=e.keyCode&&109!=e.keyCode&&189!=e.keyCode&&($(".alert").show(),e.preventDefault()):$(".alert").hide()}),$("#term2,#edTerm2,#billTerm2").click(function(){$("#termBox,#edTermBox,#billTermBox").removeClass("hidden"),$("#term1,#edTerm1,#billTerm1").removeClass("active"),$("#term,#edTerm,#billTerm").select()}),$("#term1,#edTerm1,#billTerm1").click(function(){$("#termBox,#edTermBox,#billTermBox").addClass("hidden"),$("#term2,#edTerm2,#billTerm2").removeClass("active"),$("#term,#edTerm,#billTerm").val(0)}),$("#term,#edTerm,#billTerm").blur(function(){var e=jQuery.trim($(this).val());""==e&&$(this).val(0)}),$("#term,#edTerm,#billTerm,#invoiceno").keydown(function(e){numberOnlyInput(e)}),$(".numberOnly").keydown(function(e){numberOnlyInput(e)}),$("#addProductPO").click(function(){$("#addProductPOModal").modal("show")}),$("#savePO").click(function(){function e(){var e=new Array;return $(".POtable tr").each(function(t,a){e[t]={ProdNo:$(a).find("td:eq(1)").text(),Unit:$(a).find("td:eq(4)").text(),Qty:$(a).find("td:eq(5)").text(),CostPerQty:$(a).find("td:eq(6)").text()}}),e.shift(),e}var t,a=$("#supplier").val(),d=$("#term").val(),l=$("#preparedBy").text();if($("#approved").is(":checked"))var o=l;else var o="";t=e(),t=$.toJSON(t),$.post("/savePO",{TD:t,supplier:a,term:d,preparedBy:l,approvedBy:o},function(e){1==e?(location.reload(),$("#successModal").modal("show"),$(location).attr("href","/PurchaseOrders#showPOList")):0==e&&$("#savePOError").fadeIn("fast",function(){$("#savePOError").fadeOut(4e3)})})}),$("#vwSavePOBtn").click(function(){function e(){var e=new Array;return $(".edPOTable tr").each(function(t,a){e[t]={ProdNo:$(a).find("td:eq(1)").text(),Unit:$(a).find("td:eq(4)").text(),Qty:$(a).find("td:eq(5)").text(),CostPerQty:$(a).find("td:eq(6)").text()}}),e.shift(),e}var t,a=$("#edPOId").text(),d=$('[name="vwSupplier"]').val(),l=$("#edTerm").val();t=e(),t=$.toJSON(t),$.post("/saveEditedPO",{TD:t,supplier:d,term:l,id:a},function(e){1==e?(location.reload(),"Purchase"==document.title&&$(location).attr("href","/PurchaseOrders#showPOList")):0==e&&alert("invalid move")})}),$("#saveBillPOBtn").click(function(){function e(){var e=new Array;return $(".BillPOTable > tbody  > tr").each(function(t,a){e[t]={ProductNo:$(a).find("td:eq(1)").text(),Unit:$(a).find("td:eq(4)").text(),LotNo:$(a).find("td:eq(5)").text(),ExpiryDate:$(a).find("td:eq(6)").text(),Qty:$(a).find("td:eq(7)").text(),CostPerQty:$(a).find("td:eq(8)").text(),FreebiesQty:$(a).find("td:eq(10)").text(),FreebiesUnit:$(a).find("td:eq(11)").text()}}),e}var t,a=$("#billPOId").text(),d=$("#billTerm").val(),l=$("#invoiceno").val(),o=$("#invoicedate").val();if($("#billApprove").is(":checked"))var i=1;else var i="";t=e(),t=$.toJSON(t),$.post("/savePOBill",{TD:t,term:d,id:a,SalesInvoiceNo:l,SalesInvoiceDate:o,ApprovedBy:i},function(e){1==e?(location.reload(),"Purchase"==document.title&&$(location).attr("href","/PurchaseOrders#showPOList")):0==e&&$("#billError").fadeIn("fast",function(){$("#billError").fadeOut(4e3)})})}),$("#vwSaveBillBtn").click(function(){function e(){var e=new Array;return $(".BillPOTable > tbody  > tr").each(function(t,a){e[t]={ProductNo:$(a).find("td:eq(1)").text(),Unit:$(a).find("td:eq(4)").text(),LotNo:$(a).find("td:eq(5)").text(),ExpiryDate:$(a).find("td:eq(6)").text(),Qty:$(a).find("td:eq(7)").text(),CostPerQty:$(a).find("td:eq(8)").text(),FreebiesQty:$(a).find("td:eq(10)").text(),FreebiesUnit:$(a).find("td:eq(11)").text()}}),e}var t,a=$("#vwSaveBillBtn").val(),d=$("#billTerm").val(),l=$("#invoiceno").val(),o=$("#invoicedate").val();t=e(),t=$.toJSON(t),$.post("/saveEditedPOBill",{TD:t,term:d,id:a,SalesInvoiceNo:l,SalesInvoiceDate:o},function(e){1==e?(location.reload(),"Purchase"==document.title&&$(location).attr("href","/PurchaseOrders#showPOList")):0==e&&$("#billError").fadeIn("fast",function(){$("#billError").fadeOut(4e3)})})}),$("#billCheque").click(function(){$(".chequeDiv").removeClass("hidden"),$(".cashDiv").addClass("hidden");var e;$(".BillPaymentTable > tbody > tr").each(function(t,a){e=$(a).find("td:eq(2)").text()}),$("#payTo").val(e)}),$("#billCash").click(function(){$(".cashDiv").removeClass("hidden"),$(".chequeDiv").addClass("hidden")}),$("#cashVoucher").click(function(){var e;$("#cashVoucherTable > tbody > tr").remove(),$(".BillPaymentTable > tbody > tr").each(function(t,a){e=$(a).find("td:eq(2)").text(),$("#cashVoucherTable").append('<tr>\n							<td colspan="7">Bill No '+$(a).find("td:eq(1)").text()+'</td>\n							<td class="dp"><i style="padding-right:8%;">'+$(a).find("td:eq(4)").text()+"</i></td>\n							</tr>")}),$(".cashVoucherTotal").text($("#BillPaymentTotalCost").text());var t=toWords(Number($("#BillPaymentTotalCost").text()).toFixed(0));$("#cvReceivedFrom").text(e),$("#wordVoucherTotal").text(t),$("#cashVoucherModal").modal("show"),$("#cashVoucherPrintable").printThis({debug:!1,importCSS:!0,printContainer:!0,pageTitle:"Cash Voucher",removeInline:!1,printDelay:333,header:null,formValues:!0})}),$("#chequeVoucher").click(function(){if(!$("#chequeNo").val().length||!$("#chequeDueDate").val().length||!$("#payTo").val().length)return $("#chequeError").fadeIn("fast",function(){$("#chequeError").fadeOut(4e3)}),void 0;$("#checkVoucherCheckNo").text($("#chequeNo").val()),$("#checkVoucherBank").text($("#bankNo").find("option:selected").text()),$("#checkVoucherDueDate").text($("#chequeDueDate").val()),$("#checkVoucherPayTo").text($("#payTo").val()),$("#checkVoucherTable > tbody > tr").remove(),$(".BillPaymentTable > tbody > tr").each(function(e,t){$("#checkVoucherTable").append('<tr>\n							<td colspan="7">Bill No '+$(t).find("td:eq(1)").text()+'</td>\n							<td class="dp"><i style="padding-right:8%;">'+$(t).find("td:eq(4)").text()+"</i></td>\n							</tr>")}),$(".checkVoucherTotal").text($("#BillPaymentTotalCost").text());toWords(Number($("#BillPaymentTotalCost").text()).toFixed(0));$("#checkVoucherModal").modal("show")}),$("#saveBill").click(function(){function e(){var e=new Array;return $(".BillPaymentTable > tbody  > tr").each(function(t,a){e[t]={BillNo:$(a).find("td:eq(1)").text(),amount:$(a).find("td:eq(4)").text()}}),e}var t,a=$("#BPediting").val();t=e(),t=$.toJSON(t);var d=$("#BillPaymentTotalCost").text();if($("#billCash").is(":checked"))var l=0,o=$("#cashVoucherNo").text();else if($("#billCheque").is(":checked")){if(!$("#chequeNo").val().length||!$("#chequeDueDate").val().length||!$("#payTo").val().length)return $("#chequeError").fadeIn("fast",function(){$("#chequeError").fadeOut(4e3)}),void 0;var l=1,i=$("#chequeVaucherNo").text(),r=$("#chequeNo").val(),n=$("#chequeDueDate").val(),c=$("#bankNo").find("option:selected").val(),s=$("#payTo").val()}if($("#approvedBillPayment").is(":checked"))var v=1;else var v=0;$.post("/billPayment",{id:a,TD:t,amount:d,type:l,cashVoucherNo:o,checkNo:r,checkVoucherNo:i,checkDueDate:n,BankNo:c,approved:v,PayTo:s},function(){location.reload(),$(location).attr("href","/BillPayments#BillPaymentList")})}),$(".editBillPayment").click(function(){var e=$(this).val(),t=1;$("#BPediting").val(e),$(".BillPaymentTable >tbody > tr").remove(),$.post("/getbillPayments",{id:e},function(e){if($(".billPaymentEditId").text(e.id),0==e.PaymentType)$(".cashDiv").removeClass("hidden"),$(".chequeDiv").addClass("hidden"),$("#billCash").prop("checked",!0),$("#cashVoucherNo").text(e.CashVoucherNo);else if(1==e.PaymentType){$(".chequeDiv").removeClass("hidden"),$(".cashDiv").addClass("hidden"),$("#bankNo").val(e.BankNo),$("#billCheque").prop("checked",!0),$("#chequeNo").val(e.CheckNo),$("#payTo").val(e.PayTo);var t=new Date(e.CheckDueDate);$("#chequeDueDate").val(t.getMonth()+1+"/"+t.getDate()+"/"+t.getFullYear())}e.ApprovedBy?$("#approvedBillPayment").prop("checked",!0):$("#approvedBillPayment").prop("checked",!1)}),$.post("/getbillPaymentDetails",{id:e},function(e){$.each(e,function(e,a){$(".BillPaymentTable").append('<tr id="bill'+t+'"><td id="billitemno'+t+'">'+t+'</td><td id="billId'+a.BillNo+'">'+a.BillNo+'</td>\n				<td class="supplier'+a.SupplierNo+'">'+a.SupplierName+'</td><td class="dp">'+a.InvoiceNo+'</td><td class="dp Billcost">'+money(a.Amount)+'</td><td>\n				<button class="btn btn-danger btn-xs square" id="removeBill'+t+'" onclick="removeBill('+t+')">\n				<i class="fa fa-times"></i> Remove</button></td></tr>'),t+=1,calcBillPaymentTotal()})}),$("#saveBill,.cashChecque").removeClass("hidden"),$("#BillPaymentEditing").removeClass("hidden"),$('#myTab a[href="#BillPaymentEntry"]').tab("show")}),$("#cancelBPEditing").click(function(){location.reload()})});