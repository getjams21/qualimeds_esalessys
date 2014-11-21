function addSO(t){{var e=$("#name"+t).text(),d=$("#brand"+t).text(),o=$("#unit"+t).text(),a=$(".product").DataTable(),n=a.row("#rowProd"+t).index();new Date}$(".SOtable").append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+itemno+'">'+t+"</td>\n		<td>"+e+"</td>\n		<td>"+d+"</td>\n		<td>"+o+'</td>\n		<td class="light-green editable" id="prodQtySO'+t+'">1</td>\n		<td class="light-red editable" id="prodUnitSO'+t+'"></td>\n		<td class="cost" id="prodCostSO'+t+'">0.00</td>\n		<td><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+","+t+","+n+')">\n		<i class="fa fa-times"></i> Remove</button></td></tr>'),itemno+=1,a.cell(n,4).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw(),$(".editable").editable({send:"never",type:"text",value:1,validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":void 0},emptytext:0,display:function(e){$(this).text(e),calcCostSO(t)}}),$("#saveSO").removeClass("hidden")}function calcCostSO(t){var e=$("#prodQtySO"+t).text(),d=$("#prodUnitSO"+t).text();$("#prodCostSO"+t).text(e*d),totalCostSO()}function totalCostSO(){var t=0;$(".cost").each(function(){t+=parseInt($(this).text())}),$("#SOTotalCost").text(t),(t=0)&&$("#saveSO").addClass("hidden")}function removeSO(t,e,d){var o=$(".product").DataTable();if(o.cell(d,4).data('<button class="btn btn-success btn-xs square" \n			onclick="addSO('+e+')" >\n			<i class="fa fa-check-circle"></i> Add</button>').draw(),$("#SO"+t).remove(),t+=1,$("#SO"+t).length)for(;itemno>t;)$("#SO"+t).attr("id","SO"+(t-1)),$("#itemno"+t).attr("id","itemno"+(t-1)),$("#itemno"+(t-1)).text(t-1),$("#productId"+t).attr("id","productId"+(t-1)),$("#removeSO"+t).attr("id","removeSO"+(t-1)),e=$("#productId"+(t-1)).text(),d=o.row("#rowProd"+e).index(),$("#removeSO"+(t-1)).attr("onclick","removeSO("+(t-1)+","+e+","+d+")"),t++;itemno-=1,totalCost()}function viewPO(t){$("#viewPOModal").modal("show"),$.post("/viewPO",{id:t},function(t){$("#vwPOId").text(t[0].id),$("#vwPODate").text(t[0].PODate),$("#vwSupplier").val(t[0].SupplierNo),"0"==t[0].Terms?$("#vwTerm").val("Cash"):$("#vwTerm").val(t[0].Terms),$("#vwPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#vwApprovedBy").val("N/A"):$("#vwApprovedBy").val(t[0].ApprovedBy)}),$.post("/viewPODetails",{id:t},function(t){$(".vwPOTable > tbody").html(""),counter=1;var e=0;$.each(t,function(t,d){$(".vwPOTable >tbody").append("<tr ><td>"+counter+"</td><td>"+d.ProductNo+"</td>\n	  					<td>"+d.ProductName+"</td>\n	  					<td>"+d.BrandName+"</td><td>"+d.Unit+"</td><td>"+d.Qty+"</td><td>"+d.CostPerQty+"</td>\n	  					<td>"+d.CostPerQty*d.Qty+"</td></tr>"),counter+=1,e+=d.CostPerQty*d.Qty}),$("#vwTotalCost").text(e)})}function editPO(t){$("#vwSaveBtn").addClass("hidden"),$("#editPOModal").modal("show"),$.post("/viewPO",{id:t},function(t){$("#edPOId").text(t[0].id),$("#edPODate").text(t[0].PODate),$('[name="vwSupplier"]').val(t[0].SupplierNo),"0"==t[0].Terms?($("#edTerm").val(0),$("#edTerm1").addClass("active"),$("#edTerm2").removeClass("active"),$("#edTermBox").addClass("hidden")):($("#edTerm").val(t[0].Terms),$("#edTerm1").removeClass("active"),$("#edTerm2").addClass("active"),$("#edTerm2").prop("disabled",!1),$("#edTermBox").removeClass("hidden")),$("#edPreparedBy").val(t[0].PreparedBy),""==t[0].ApprovedBy?$("#edApprovedBy").val("N/A"):$("#edApprovedBy").val(t[0].ApprovedBy)}),$.post("/viewPODetails",{id:t},function(t){$(".edPOTable > tbody").html(""),counter=1;var e=0;$.each(t,function(t,d){$(".edPOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+d.ProductNo+'">'+d.ProductNo+"</td>\n	  					<td>"+d.ProductName+"</td>\n	  					<td>"+d.BrandName+"</td><td>"+d.Unit+'</td><td class="vweditable" id="edQty'+d.ProductNo+'">'+d.Qty+'</td><td class="vweditable" id="edUnit'+d.ProductNo+'">'+d.CostPerQty+'</td>\n	  					<td class="ecost"id="edCost'+d.ProductNo+'">'+d.CostPerQty*d.Qty+'</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),e+=d.CostPerQty*d.Qty,editable(d.ProductNo),counter+=1}),$("#edTotalCost").text(e)})}function editable(t){$(".vweditable").editable({send:"never",type:"text",validate:function(t){return""==$.trim(t)?"This field is required":""==$.isNumeric(t)||0==t?"Please input a valid number greater than 0":($("#vwSavePOBtn").removeClass("hidden"),void 0)},emptytext:0,display:function(e){$(this).text(e),edcalcCost(t)}})}function edcalcCost(t){var e=$("#edQty"+t).text(),d=$("#edUnit"+t).text();$("#edCost"+t).text(e*d),edtotalCost()}function edtotalCost(){var t=0;$(".ecost").each(function(){t+=parseInt($(this).text())}),$("#edPOTotalCost").text(t),0==t&&$("#vwSavePOBtn").addClass("hidden")}function vwaddPO(t){{var e=$("#vwname"+t).text(),d=$("#vwbrand"+t).text(),o=$("#vwunit"+t).text(),a=$(".vwproduct").DataTable();a.row("#vwrowProd"+t).index()}$("#vwProd"+t).length?$("#prodError").fadeIn("fast",function(){$("#prodError").fadeOut(4e3)}):($(".edPOTable >tbody").append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+t+'">'+t+"</td>\n	  					<td>"+e+"</td>\n	  					<td>"+d+"</td><td>"+o+'</td><td class="vweditable" id="edQty'+t+'">1</td><td class="vweditable" id="edUnit'+t+'">1</td>\n	  					<td class="ecost"id="edCost'+t+'">1</td><td><button class="btn btn-danger \n	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >\n						<i class="fa fa-times" ></i> Remove</button></td></tr>'),counter+=1,editable(t),$("#vwSavePOBtn").removeClass("hidden"))}function vwRemovePO(t){if($("#vwPO"+t).remove(),t+=1,$("#vwPO"+t).length)for(;$("#vwPO"+t).length;)$("#vwPO"+t).attr("id","vwPO"+(t-1)),$("#vwItemno"+t).attr("id","vwItemno"+(t-1)),$("#vwItemno"+(t-1)).text(t-1),$("#vwRemovePO"+t).attr("id","vwRemovePO"+(t-1)),$("#vwRemovePO"+(t-1)).attr("onclick","vwRemovePO("+(t-1)+")"),t++;counter-=1,edtotalCost(),$("#vwSavePOBtn").removeClass("hidden")}var itemno=1,counter=1;$(document).ready(function(){$("#term2,#edTerm2").click(function(){$("#termBox,#edTermBox").removeClass("hidden"),$("#term1,#edTerm1").removeClass("active"),$("#term,#edTerm").select()}),$("#term1,#edTerm1").click(function(){$("#termBox,#edTermBox").addClass("hidden"),$("#term2,#edTerm2").removeClass("active"),$("#term,#edTerm").val(0)}),$("#term,#edTerm").blur(function(){var t=jQuery.trim($(this).val());""==t&&$(this).val(0)}),$("#term,#edTerm").keydown(function(t){numberOnlyInput(t)}),$("#addProductPO").click(function(){$("#addProductPOModal").modal("show")}),$("#saveSO").click(function(){function t(){var t=new Array;return $(".SOtable tr").each(function(e,d){t[e]={ProdNo:$(d).find("td:eq(1)").text(),Unit:$(d).find("td:eq(4)").text(),Qty:$(d).find("td:eq(5)").text(),UnitPrice:$(d).find("td:eq(6)").text()}}),t.shift(),t}var e,d=$("#customer").val(),o=$("#term").val(),a=$("#medReps").val();e=t(),e=$.toJSON(e),$.post("/saveSO",{TD:e,customer:d,term:o,UserNo:a},function(t){1==t?$(".SOsaved").show().fadeOut(5e3):0==t&&$("#savePOError").fadeIn("fast",function(){$("#savePOError").fadeOut(4e3)})})}),$("#vwSavePOBtn").click(function(){function t(){var t=new Array;return $(".edPOTable tr").each(function(e,d){t[e]={ProdNo:$(d).find("td:eq(1)").text(),Unit:$(d).find("td:eq(4)").text(),Qty:$(d).find("td:eq(5)").text(),CostPerQty:$(d).find("td:eq(6)").text()}}),t.shift(),t}var e,d=$("#edPOId").text(),o=$('[name="vwSupplier"]').val(),a=$("#edTerm").val();e=t(),e=$.toJSON(e),$.post("/saveEditedPO",{TD:e,supplier:o,term:a,id:d},function(t){1==t?location.reload():0==t&&alert("invalid move")})})});