function addSO(t){var e,d=$("#prodId"+t).text(),n=$("#customer").val(),i=$("#name"+t).text(),o=$("#brand"+t).text(),a=$("#unit"+t).text(),r=$(".product").DataTable(),s=$("#lotNo"+t).text(),l=$("#ExpDate"+t).val(),c=$("#unitQty"+t).text(),v=$("#unitQtyR"+t).val(),u=$("#unitPrice"+t).text(),m=r.row("#rowProd"+t).index(),p=(new Date,$("#isAdmin").val());$.post(reroute+"/get-product-markup",{prodNum:d},function(t){if(t){var d=t.ActiveMarkup;1==d?e=t.Markup1:2==d?e=t.Markup2:3==d&&(e=t.Markup3)}}),$(".SOtable").append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>\n		<td id="prdoNo'+itemno+'">'+d+"</td>\n		<td>"+i+"</td>\n		<td>"+o+"</td>\n		<td>"+s+"</td>\n		<td>"+l+'</td>\n		<td><select class="form-control square" name="unit" id="unit'+itemno+'">\n                  <option value="'+a+'">'+a+'</option>\n                  <option value="pcs">pcs</option>\n                </select></td>\n        <input id="unitAv'+t+'" type="hidden" value="'+c+'">\n        <input id="unitAvR'+t+'" type="hidden" value="'+v+'">\n		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">1</td>\n		<td class="light-red ed" id="prodUntSO'+itemno+'" value="'+u+'">'+u+'</td>\n		<td class="cost" id="prodCostSO'+itemno+'">0.00</td>\n		<td>\n		<center><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+","+t+","+m+')">\n		<i class="fa fa-times"></i> Remove</button>&nbsp;<button class="btn btn-primary btn-xs square" id="vwPriceList'+itemno+'" onclick="vwPriceList('+itemno+","+n+","+d+')">\n		<i class="fa fa-eye"></i> Price List</button></center></td></tr>');var f=$("#unitAv"+t).val();$("select[id=unit"+itemno+"]").on("change",function(){"pcs"==$(this).val()?(f=$("#unitAvR"+t).val(),$("#prodQtySO"+itemno).text("1")):(f=$("#unitAv"+t).val(),$("#prodQtySO"+itemno).text("1"),$("#unitQty"+t).text(c))}),itemno+=1,r.cell(m,8).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw(),$(".editable").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){if(parseFloat(t)<=parseFloat(f)){$("#invalidQty").hide(),$(this).text(t);var e=$(this).attr("id").substring(9);calcCostSO(e)}else $(this).text("1"),$("#invalidQty").show()}}),$(".ed").editable({send:"never",type:"text",value:u,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var d=$(this).attr("id").substring(9);calcCostSO(d,e,p)}}),$("#saveSO").removeClass("hidden")}function calcCostSO(t,e,d){var n=parseInt($("#prodQtySO"+t).text()),i=parseFloat($("#prodUntSO"+t).text()).toFixed(2);i<parseFloat(e)&&(1!=d&&($("#prodUntSO"+t).text(e),i=parseFloat($("#prodUntSO"+t).text()).toFixed(2)),$(".warning-modal").modal("show")),$("#prodCostSO"+t).text(cmoney(parseFloat(n*i).toFixed(2))),$("#prodCostSO"+t).val(parseFloat(n*i).toFixed(2)),totalCostSO()}function totalCostSO(){var t=0;$(".cost").each(function(){t+=parseFloat($(this).val())}),$("#SOTotalCost").text(cmoney(t)),(t=0)&&$("#saveSO").addClass("hidden")}function removeSO(t,e,d){var n=$(".product").DataTable();if(n.cell(d,8).data('<button class="btn btn-success btn-xs square" \n			onclick="addSO('+e+')" >\n			<i class="fa fa-check-circle"></i> Add</button>').draw(),$("#SO"+t).remove(),t+=1,$("#SO"+t).length)for(;itemno>t;)$("#SO"+t).attr("id","SO"+(t-1)),$("#itemno"+t).attr("id","itemno"+(t-1)),$("#itemno"+(t-1)).text(t-1),$("#productId"+t).attr("id","productId"+(t-1)),$("#removeSO"+t).attr("id","removeSO"+(t-1)),e=$("#productId"+(t-1)).text(),d=n.row("#rowProd"+e).index(),$("#removeSO"+(t-1)).attr("onclick","removeSO("+(t-1)+","+e+","+d+")"),t++;itemno-=1,totalCost()}function vwPriceList(t,e,d){$.post(reroute+"/view-price-list",{custNo:e,prodNo:d},function(e){e&&($.each(e,function(e,d){$(".pricelist >tbody").find("tr").remove().end(),$(".pricelist >tbody").append("<tr>\n  					<td>"+d.id+"</td>\n  					<td>"+d.ProductName+"</td>\n  					<td>"+d.date+"</td>\n  					<td>"+d.UnitPrice+'</td>\n  					<td>\n  					<button class="btn btn-primary btn-xs square" \n  					onclick="addPrice('+t+","+d.UnitPrice+')">\n					<i class="fa fa-plus"></i>Add</button></td>\n  				</tr>')}),$("#priceListModal").modal("show"))})}function addPrice(t,e){$("#prodUntSO"+t).val(e),$("#prodUntSO"+t).text(e),calcCostSO(t),$("#priceListModal").modal("hide")}function viewPO(t){alert(reroute),$("#viewPOModal").modal("show"),$.post(reroute+"/viewPO",{id:t},function(t){$("#vwPOId").text(t[0].id),$("#vwPODate").text(t[0].PODate),$("#vwSupplier").val(t[0].SupplierNo),"0"==t[0].Terms?$("#vwTerm").val("Cash"):$("#vwTerm").val(t[0].Terms),$("#vwPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#vwApprovedBy").val("N/A"):$("#vwApprovedBy").val(t[0].ApprovedBy)}),$.post(reroute+"/viewPODetails",{id:t},function(t){$(".vwPOTable > tbody").html(""),counter=1;var e=0;$.each(t,function(t,d){$(".vwPOTable >tbody").append("<tr ><td>"+counter+"</td><td>"+d.ProductNo+"</td>\n	  					<td>"+d.ProductName+"</td>\n	  					<td>"+d.BrandName+"</td><td>"+d.Unit+"</td><td>"+d.Qty+"</td><td>"+d.CostPerQty+"</td>\n	  					<td>"+d.CostPerQty*d.Qty+"</td></tr>"),counter+=1,e+=d.CostPerQty*d.Qty}),$("#vwTotalCost").text(e)})}function editSO(t){$("#vwSaveBtn").addClass("hidden"),$("#editSOModal").modal("show");var e=0;$.post(reroute+"/viewSO",{id:t},function(t){e=t[0].CustomerNo,$("#edSOId").text(t[0].id),$("#edSODate").text(t[0].SalesOrderDate),$('[name="vwCustomer"]').val(t[0].CustomerNo),$('select#medReps option[value="'+t[0].UserNo+'"]').attr("selected",!0),"0"==t[0].Terms?($("#edTerm").val(0),$("#edTerm1").addClass("active"),$("#edTerm2").removeClass("active"),$("#edTermBox").addClass("hidden")):($("#edTerm").val(t[0].Terms),$("#edTerm1").removeClass("active"),$("#edTerm2").addClass("active"),$("#edTerm2").prop("disabled",!1),$("#edTermBox").removeClass("hidden")),$("#edPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#edApprovedBy").val("N/A"):$("#edApprovedBy").val(t[0].ApprovedBy)}),$.post(reroute+"/viewSODetails",{id:t},function(t){function d(t){var e=$("#edQty"+t).text(),d=$("#edUnt"+t).text();$("#edCost"+t).text(parseFloat(e*d)),n()}function n(){var t=0;$(".ecost").each(function(){t+=parseFloat($(this).text())}),$("#edSOTotalCost").text(money(t)),0==t?$("#vwSaveSOBtn").addClass("hidden"):$("#vwSaveSOBtn").removeClass("hidden")}$(".edSOTable > tbody").html(""),counter=1;var i=0;$.each(t,function(t,n){if("box"==n.Unit||"Box"==n.Unit)var o="Pcs";else if("pcs"==n.Unit||"Pcs"==n.Unit)var o="Box";var a=n.ProductNo;$(".edSOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+n.ProductNo+'">'+n.ProductNo+"</td>\n	  					<td>"+n.ProductName+"</td>\n	  					<td>"+n.BrandName+"</td>\n	  					<td>"+n.LotNo+"</td>\n						<td>"+n.ExpiryDate+'</td>\n	  					<td><select class="form-control square" name="unit" id="unit'+counter+'">\n		                  <option value="'+n.Unit+'">'+n.Unit+'</option>\n		                  <option value="'+o+'">'+o+'</option>\n		                </select></td>\n	  					<td class="vweditable" id="edQty'+counter+'">'+n.Qty+'</td>\n	  					<td class="vwEd" id="edUnt'+counter+'">'+money(n.UnitPrice)+'</td>\n	  					<td class="ecost"id="edCost'+counter+'">'+money(n.UnitPrice*n.Qty)+'</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button>&nbsp;<button class="btn btn-primary btn-xs square" id="vwPriceList'+counter+'" onclick="vwEdPriceList('+counter+","+e+","+a+')">\n		<i class="fa fa-eye"></i> Price List</button></td></tr>'),i+=n.UnitPrice*n.Qty,counter+=1,$(".vweditable").editable({send:"never",type:"text",validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(5);d(e)}}),$(".vwEd").editable({send:"never",type:"text",validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(5);d(e)}})}),$("#edSOTotalCost").text(i)})}function vwEdPriceList(t,e,d){$.post(reroute+"/view-price-list",{custNo:e,prodNo:d},function(e){e&&($.each(e,function(e,d){$(".pricelist >tbody").find("tr").remove().end(),$(".pricelist >tbody").append("<tr>\n  					<td>"+d.id+"</td>\n  					<td>"+d.ProductName+"</td>\n  					<td>"+d.date+"</td>\n  					<td>"+d.UnitPrice+'</td>\n  					<td>\n  					<button class="btn btn-primary btn-xs square" \n  					onclick="addEdPrice('+t+","+d.UnitPrice+')">\n					<i class="fa fa-plus"></i>Add</button></td>\n  				</tr>')}),$("#priceListModal").modal("show"))})}function addEdPrice(t,e){$("#edUnt"+t).val(e),$("#edUnt"+t).text(e);var d=$("#edQty"+t).text(),n=$("#edUnt"+t).text();$("#edCost"+t).text(parseFloat(d*n)),edtotalCostSO(),$("#priceListModal").modal("hide")}function edtotalCostSO(){var t=0;$(".ecost").each(function(){t+=parseFloat($(this).text())}),$("#edSOTotalCost").text(money(t)),0==t?$("#vwSaveSOBtn").addClass("hidden"):$("#vwSaveSOBtn").removeClass("hidden")}function vwaddSO(t){{var e=$("#prodId"+t).text(),d=$("#name"+t).text(),n=$("#brand"+t).text(),i=$("#unit"+t).text(),o=$(".product").DataTable(),a=$("#lotNo"+t).text(),r=$("#ExpDate"+t).val(),s=$("#unitQty"+t).text(),l=$("#unitQtyR"+t).val(),c=$("#unitPrice"+t).text(),v=o.row("#rowProd"+t).index();new Date}$(".edSOTable").append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>\n		<td id="prdoNo'+itemno+'">'+e+"</td>\n		<td>"+d+"</td>\n		<td>"+n+"</td>\n		<td>"+a+"</td>\n		<td>"+r+'</td>\n		<td><select class="form-control square" name="unit" id="unit'+itemno+'">\n                  <option value="'+i+'">'+i+'</option>\n                  <option value="pcs">pcs</option>\n                </select></td>\n        <input id="unitAv'+t+'" type="hidden" value="'+s+'">\n        <input id="unitAvR'+t+'" type="hidden" value="'+l+'">\n		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">1</td>\n		<td class="light-red ed" id="prodUntSO'+itemno+'" value="'+c+'">'+c+'</td>\n		<td class="ecost" id="prodCostSO'+itemno+'">0.00</td>\n		<td><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+","+t+","+v+')">\n		<i class="fa fa-times"></i> Remove</button></td></tr>');var u=$("#unitAv"+t).val();$("select[id=unit"+itemno+"]").on("change",function(){"pcs"==$(this).val()?(u=$("#unitAvR"+t).val(),$("#prodQtySO"+itemno).text("1")):(u=$("#unitAv"+t).val(),$("#prodQtySO"+itemno).text("1"),$("#unitQty"+t).text(s))}),itemno+=1,o.cell(v,8).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw(),$(".editable").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){if(parseFloat(t)<=parseFloat(u)){$("#invalidQty").hide(),$(this).text(t);var e=$(this).attr("id").substring(9);edcalcCostSO(e)}else $(this).text("1"),$("#invalidQty").show()}}),$(".ed").editable({send:"never",type:"text",value:c,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(9);edcalcCostSO(e)}}),$("#vwSaveSOBtn").removeClass("hidden")}function edcalcCostSO(t){var e=parseInt($("#prodQtySO"+t).text()),d=parseFloat($("#prodUntSO"+t).text()).toFixed(2);$("#prodCostSO"+t).text(parseFloat(e*d).toFixed(2)),edtotalCostSO()}function edtotalCostSO(){var t=0;$(".ecost").each(function(){t+=parseFloat($(this).text())}),$("#edSOTotalCost").text(t.toFixed(2)),(t=0)&&$("#vwSaveSOBtn").addClass("hidden")}function vwRemovePO(t){if($("#vwPO"+t).remove(),t+=1,$("#vwPO"+t).length)for(;$("#vwPO"+t).length;)$("#vwPO"+t).attr("id","vwPO"+(t-1)),$("#vwItemno"+t).attr("id","vwItemno"+(t-1)),$("#vwItemno"+(t-1)).text(t-1),$("#vwRemovePO"+t).attr("id","vwRemovePO"+(t-1)),$("#vwRemovePO"+(t-1)).attr("onclick","vwRemovePO("+(t-1)+")"),t++;counter-=1,edtotalCost(),$("#vwSavePOBtn").removeClass("hidden")}var reroute="/user/"+$('meta[name="_token"]').attr("content"),itemno=1,counter=1;$(document).ready(function(){$("#term2,#edTerm2").click(function(){$("#termBox,#edTermBox").removeClass("hidden"),$("#term1,#edTerm1").removeClass("active"),$("#term,#edTerm").select()}),$("#term1,#edTerm1").click(function(){$("#termBox,#edTermBox").addClass("hidden"),$("#term2,#edTerm2").removeClass("active"),$("#term,#edTerm").val(0)}),$("#term,#edTerm").blur(function(){var t=jQuery.trim($(this).val());""==t&&$(this).val(0)}),$("#term,#edTerm").keydown(function(t){numberOnlyInput(t)}),$("#addProductPO").click(function(){$("#addProductPOModal").modal("show")}),$("#saveSO").click(function(){function t(){var t=new Array,e=1;return $(".SOtable tr").each(function(d,n){t[d]={ProdNo:$(n).find("td:eq(1)").text(),LotNo:$(n).find("td:eq(4)").text(),ExpiryDate:$(n).find("td:eq(5)").text(),Unit:$(n).find("td:eq(6) select option:selected").val(),Qty:$(n).find("td:eq(7)").text(),UnitPrice:$(n).find("td:eq(8)").text()},e++}),t.shift(),t}var e,d=$("#customer").val(),n=$("#term").val(),i=$("#medReps").val();e=t(),e=$.toJSON(e);var o=$("#preparedBy").text();if($("#approved").is(":checked"))var a=o;else var a="";$.post(reroute+"/saveSO",{TD:e,CustomerNo:d,term:n,UserNo:i,PreparedBy:o,approvedBy:a},function(t){1==t?(location.reload(),$(location).attr("href","/SalesOrders#showSOList")):0==t&&$("#savePOError").fadeIn("fast",function(){$("#savePOError").fadeOut(4e3)})})}),$("#vwSaveSOBtn").click(function(){function t(){var t=new Array,e=1;return $(".edSOTable tr").each(function(d,n){t[d]={ProdNo:$(n).find("td:eq(1)").text(),LotNo:$(n).find("td:eq(4)").text(),ExpiryDate:$(n).find("td:eq(5)").text(),Unit:$(n).find("td:eq(6) select option:selected").val(),Qty:$(n).find("td:eq(7)").text(),UnitPrice:$(n).find("td:eq(8)").text()},e++}),t.shift(),t}var e,d=$("#edSOId").text(),n=$('[name="vwCustomer"]').val(),i=$("#medReps").val(),o=$("#edTerm").val();e=t(),e=$.toJSON(e),$.post(reroute+"/saveEditedSO",{TD:e,customer:n,UserNo:i,term:o,id:d},function(t){1==t?location.reload():0==t&&alert("invalid move")})})});