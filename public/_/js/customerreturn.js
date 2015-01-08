function addCR(t){var e=$("#name"+t).text(),a=$("#brand"+t).text(),i=$("#wholesale"+t).text(),o=$(".product").DataTable(),n=0,r=o.row("#rowProd"+t).index(),s=new Date;$(".IAtable").append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>\n		<td id="prdoNo'+itemno+'">'+t+"</td>\n		<td>"+e+"</td>\n		<td>"+a+'</td>\n		<td class="editable-default" id="lotNo'+t+'"><i></i></td>\n		<td class="dateEditable">'+s.getFullYear()+"-"+s.getMonth()+"-"+s.getDate()+'\n		</td>\n		<td><select class="form-control square" name="unit" id="unit'+itemno+'">\n                  <option value="'+i+'">'+i+'</option>\n                  <option value="pcs">pcs</option>\n                </select></td>\n		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">1</td>\n		<td class="light-red ed" id="prodUntSO'+itemno+'">0.00</td>\n		<td class="cost" id="prodCostSO'+itemno+'">0.00</td>\n		<td><button class="btn btn-danger btn-xs square" id="removeIA'+itemno+'" onclick="removeIA('+itemno+","+t+","+r+')">\n		<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,$(".editable-default").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":void 0},emptytext:0,display:function(t){$(this).text(t)}}),$(".dateEditable").editable({type:"combodate",format:"YYYY-MM-DD",viewformat:"YYYY-MM-DD",template:"D / MMMM / YYYY",validate:function(t){return""==$.trim(t)?"This field is required":void 0},combodate:{minYear:d.getFullYear(),maxYear:d.getFullYear()+10,minuteStep:1}}),$(".editable").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(9);calcCostSO(e)}}),$(".ed").editable({send:"never",type:"text",value:n,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(9);calcCostSO(e)}}),$("#saveSO").removeClass("hidden")}function calcCostSO(t){var e=parseInt($("#prodQtySO"+t).text()),d=parseFloat($("#prodUntSO"+t).text()).toFixed(2);$("#prodCostSO"+t).text(parseFloat(e*d).toFixed(2)),totalCostSO()}function totalCostSO(){var t=0;$(".cost").each(function(){t+=parseFloat($(this).text())}),$("#SOTotalCost").text(t.toFixed(2)),(t=0)&&$("#saveSO").addClass("hidden")}function removeIA(t,e,d){var a=$(".product").DataTable();if($("#SO"+t).remove(),t+=1,$("#SO"+t).length)for(;itemno>t;)$("#SO"+t).attr("id","SO"+(t-1)),$("#itemno"+t).attr("id","itemno"+(t-1)),$("#itemno"+(t-1)).text(t-1),$("#productId"+t).attr("id","productId"+(t-1)),$("#removeSO"+t).attr("id","removeSO"+(t-1)),e=$("#productId"+(t-1)).text(),d=a.row("#rowProd"+e).index(),$("#removeSO"+(t-1)).attr("onclick","removeSO("+(t-1)+","+e+","+d+")"),t++;itemno-=1,totalCost()}function viewPO(t){$("#viewPOModal").modal("show"),$.post("/viewPO",{id:t},function(t){$("#vwPOId").text(t[0].id),$("#vwPODate").text(t[0].PODate),$("#vwSupplier").val(t[0].SupplierNo),"0"==t[0].Terms?$("#vwTerm").val("Cash"):$("#vwTerm").val(t[0].Terms),$("#vwPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#vwApprovedBy").val("N/A"):$("#vwApprovedBy").val(t[0].ApprovedBy)}),$.post("/viewPODetails",{id:t},function(t){$(".vwPOTable > tbody").html(""),counter=1;var e=0;$.each(t,function(t,d){$(".vwPOTable >tbody").append("<tr ><td>"+counter+"</td><td>"+d.ProductNo+"</td>\n	  					<td>"+d.ProductName+"</td>\n	  					<td>"+d.BrandName+"</td><td>"+d.Unit+"</td><td>"+d.Qty+"</td><td>"+d.CostPerQty+"</td>\n	  					<td>"+d.CostPerQty*d.Qty+"</td></tr>"),counter+=1,e+=d.CostPerQty*d.Qty}),$("#vwTotalCost").text(e)})}function editIA(t){$("#vwSaveBtn").addClass("hidden"),$("#editIAModal").modal("show"),$.post("/viewIA",{id:t},function(t){$("#edIAId").text(t[0].id),$("#edIADate").text(t[0].AdjustmentDate),$('select#branch option[value="'+t[0].BranchNo+'"]').attr("selected",!0),$("#remarks").text(t[0].Remarks),$("#edPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#edApprovedBy").val("N/A"):$("#edApprovedBy").val(t[0].ApprovedBy)}),$.post("/viewIADetails",{id:t},function(e){function a(t){var e=$("#edQty"+t).text(),d=$("#edUnt"+t).text();$("#edCost"+t).text(money(parseFloat(e*d))),i()}function i(){var t=0;$(".cost").each(function(){t+=parseFloat($(this).text())}),$("#edSOTotalCost").text(money(parseFloat(t))),0==t?$("#vwSaveSOBtn").addClass("hidden"):$("#vwSaveSOBtn").removeClass("hidden")}$(".edSOTable > tbody").html(""),counter=1;var o=0;$.each(e,function(e,i){if("box"==i.Unit||"Box"==i.Unit)var n="Pcs";else if("pcs"==i.Unit||"Pcs"==i.Unit)var n="Box";var r=parseFloat(i.CostPerQty)*parseFloat(i.Qty);$(".edSOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+i.ProductNo+'">'+i.ProductNo+"</td>\n	  					<td>"+i.ProductName+"</td>\n	  					<td>"+i.BrandName+'</td>\n	  					<td class="editable-default" id="lotNo'+t+'"><i>'+i.LotNo+'</i></td>\n						<td class="dateEditable">'+i.ExpiryDate+'</td>\n	  					<td><select class="form-control square" name="unit" id="unit">\n		                  <option value="'+i.Unit+'">'+i.Unit+'</option>\n		                  <option value="'+n+'">'+n+'</option>\n		                </select></td>\n	  					<td class="vweditable" id="edQty'+counter+'">'+parseInt(i.Qty)+'</td>\n	  					<td class="vweditable" id="edUnt'+counter+'">'+money(i.CostPerQty)+'</td>\n	  					<td class="cost"id="edCost'+counter+'">'+r.toFixed(2)+'</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),o+=i.CostPerQty*i.Qty,counter+=1,$(".editable-default").editable({send:"never",type:"text",value:i.LotNo,validate:function(t){return""==$.trim(t)?"This field is required":void 0},emptytext:0,display:function(t){$(this).text(t)}}),$(".dateEditable").editable({type:"combodate",format:"YYYY-MM-DD",viewformat:"YYYY-MM-DD",template:"D / MMMM / YYYY",validate:function(t){return""==$.trim(t)?"This field is required":void 0},combodate:{minYear:d.getFullYear(),maxYear:d.getFullYear()+10,minuteStep:1}}),$(".vweditable").editable({send:"never",type:"text",validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(5);a(e)}})})})}function vwaddIA(t){var e=$("#name"+t).text(),a=$("#brand"+t).text(),i=$("#wholesale"+t).text(),o=$(".product").DataTable(),n=0,r=o.row("#rowProd"+t).index(),s=new Date;$(".edSOTable").append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>\n		<td id="prdoNo'+itemno+'">'+t+"</td>\n		<td>"+e+"</td>\n		<td>"+a+'</td>\n		<td class="editable-default" id="lotNo'+t+'"><i></i></td>\n		<td class="dateEditable">'+s.getFullYear()+"-"+s.getMonth()+"-"+s.getDate()+'\n		</td>\n		<td><select class="form-control square" name="unit" id="unit'+itemno+'">\n                  <option value="'+i+'">'+i+'</option>\n                  <option value="pcs">pcs</option>\n                </select></td>\n		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">1</td>\n		<td class="light-red ed" id="prodUntSO'+itemno+'">0.00</td>\n		<td class="cost" id="prodCostSO'+itemno+'">0.00</td>\n		<td><button class="btn btn-danger btn-xs square" id="removeIA'+itemno+'" onclick="removeIA('+itemno+","+t+","+r+')">\n		<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,$(".editable-default").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":void 0},emptytext:0,display:function(t){$(this).text(t)}}),$(".dateEditable").editable({type:"combodate",format:"YYYY-MM-DD",viewformat:"YYYY-MM-DD",template:"D / MMMM / YYYY",validate:function(t){return""==$.trim(t)?"This field is required":void 0},combodate:{minYear:d.getFullYear(),maxYear:d.getFullYear()+10,minuteStep:1}}),$(".editable").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(9);edcalcCostSO(e)}}),$(".ed").editable({send:"never",type:"text",value:n,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(t){$(this).text(t);var e=$(this).attr("id").substring(9);edcalcCostSO(e)}}),$("#vwSaveSOBtn").removeClass("hidden")}function edcalcCostSO(t){var e=parseInt($("#prodQtySO"+t).text()),d=parseFloat($("#prodUntSO"+t).text()).toFixed(2);$("#prodCostSO"+t).text(parseFloat(e*d).toFixed(2)),edtotalCostSO()}function edtotalCostSO(){var t=0;$(".cost").each(function(){t+=parseFloat($(this).text())}),$("#edSOTotalCost").text(money(parseFloat(t))),(t=0)&&$("#vwSaveSOBtn").addClass("hidden")}function vwRemovePO(t){if($("#vwPO"+t).remove(),t+=1,$("#vwPO"+t).length)for(;$("#vwPO"+t).length;)$("#vwPO"+t).attr("id","vwPO"+(t-1)),$("#vwItemno"+t).attr("id","vwItemno"+(t-1)),$("#vwItemno"+(t-1)).text(t-1),$("#vwRemovePO"+t).attr("id","vwRemovePO"+(t-1)),$("#vwRemovePO"+(t-1)).attr("onclick","vwRemovePO("+(t-1)+")"),t++;counter-=1,edtotalCost(),$("#vwSaveSOBtn").removeClass("hidden")}var sample="sample",itemno=1,counter=1;$(document).ready(function(){$("#term2,#edTerm2").click(function(){$("#termBox,#edTermBox").removeClass("hidden"),$("#term1,#edTerm1").removeClass("active"),$("#term,#edTerm").select()}),$("#term1,#edTerm1").click(function(){$("#termBox,#edTermBox").addClass("hidden"),$("#term2,#edTerm2").removeClass("active"),$("#term,#edTerm").val(0)}),$("#term,#edTerm").blur(function(){var t=jQuery.trim($(this).val());""==t&&$(this).val(0)}),$("#term,#edTerm").keydown(function(t){numberOnlyInput(t)}),$("#addProductPO").click(function(){$("#addProductPOModal").modal("show")}),$("#saveSO").click(function(){function t(){var t=new Array,e=1;return $(".IAtable tr").each(function(d,a){t[d]={ProdNo:$(a).find("td:eq(1)").text(),LotNo:$(a).find("td:eq(4)").text(),ExpiryDate:$(a).find("td:eq(5)").text(),Unit:$(a).find("td:eq(6) select option:selected").val(),Qty:$(a).find("td:eq(7)").text(),CostPerQty:$(a).find("td:eq(8)").text()},e++}),t.shift(),t}var e,d=$("#branch").val(),a=$("#remarks").val();e=t(),e=$.toJSON(e);var i=$("#preparedBy").text();if($("#approved").is(":checked"))var o=i;else var o="";$.post("/saveIA",{TD:e,BranchNo:d,Remarks:a,PreparedBy:i,approvedBy:o},function(t){1==t?(location.reload(),$(location).attr("href","/inventory-adjustment#showIAList")):0==t&&$("#savePOError").fadeIn("fast",function(){$("#savePOError").fadeOut(4e3)})})}),$("#vwSaveSOBtn").click(function(){function t(){var t=new Array,e=1;return $(".edSOTable tr").each(function(d,a){t[d]={ProdNo:$(a).find("td:eq(1)").text(),LotNo:$(a).find("td:eq(4)").text(),ExpiryDate:$(a).find("td:eq(5)").text(),Unit:$(a).find("td:eq(6) select option:selected").val(),Qty:$(a).find("td:eq(7)").text(),CostPerQty:$(a).find("td:eq(8)").text()},e++}),t.shift(),t}var e,d=$("#edIAId").text(),a=$("#branch").val(),i=$("#remarks").val();e=t(),e=$.toJSON(e);var o=$("#preparedBy").text();if($("#approved").is(":checked"))var n=o;else var n="";$.post("/saveEditedIA",{TD:e,BranchNo:a,Remarks:i,PreparedBy:o,approvedBy:n,id:d},function(t){1==t?(location.reload(),$(location).attr("href","/inventory-adjustment#showIAList")):0==t&&$("#savePOError").fadeIn("fast",function(){$("#savePOError").fadeOut(4e3)})})}),$("#td-remarks").hover(function(){$(this).popover("show")},function(){$(this).popover("hide")})});