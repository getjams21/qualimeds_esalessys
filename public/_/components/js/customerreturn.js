var reroute='/user/'+$('meta[name="_token"]').attr('content');
var sample = 'sample';
var itemno = 1;
var counter = 1;
function addCR(id){
	var table = $('.product').DataTable();
	var index=table.row('#rowProd'+id).index();
	$('#SalesInvoiceNo').val(id);
	$.post(reroute+'/fetchSIItems',{id:id},function(data){
		if(data){
			$('.CRTable').find('tr').remove().end();
			var Qty;
			$.each(data, function(key, value) {
				Qty = parseInt(value.Qty);
				$('.CRTable').append('
					<tr id="SO'+itemno+'">
						<td id="itemno'+itemno+'">'+itemno+'</td>
						<td id="prdoNo'+value.ProductNo+'">'+value.ProductNo+'</td>
						<td id="prodName'+value.id+'">'+value.ProductName+'</td>
						<td id="brand'+value.id+'">'+value.BrandName+'</td>
						<td id="lotNo'+id+'">'+value.LotNo+'</td>
						<td id="expDate'+id+'">'+value.ExpiryDate+'</td>
						<td id="unit'+id+'">'+value.Unit+'</td>
						<td class="light-green editable" id="prodQtySO'+value.id+'" value="'+value.Qty+'">'+value.Qty+'</td>
						<td id="prodUntSO'+value.id+'">'+money(value.UnitPrice)+'</td>
						<td class="cost" id="prodCostSO'+value.id+'">0.00</td>
						<td id="freebiesQty'+value.id+'">'+parseInt(value.FreebiesQty)+'</td>
						<td id="freebiesQty'+value.id+'">'+value.FreebiesUnit+'</td>
						<td><button class="btn btn-danger btn-xs square" id="removeIA'+value.id+'" onclick="removeIA('+itemno+','+id+','+index+')">
						<i class="fa fa-times"></i> Remove</button></td>
						<input type="hidden" id="prevQty'+value.id+'" value="'+Qty+'">
					</tr>
				');
			itemno +=1;
			// table.cell( index, 7 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
			// var unitAvailable = $('#unitAv'+id).val();
			$('.editable').editable({
					send: 'never', 
				    type: 'text',
				    value:Qty,
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
				   		var rowID = $(this).attr('id').substring(9);
				        calcCostSO(rowID,Qty);
				  	}	
				});
			$('#saveSO').removeClass('hidden');
			});
		}
	});
}
function calcCostSO(id){
	var qty = parseInt($('#prodQtySO'+id).text());
	var prevQty = parseInt($('#prevQty'+id).val());
	if(qty > prevQty){
		$('#invalidQty').show();
		$('#saveSO').attr('disabled', 'disabled');
		return false;
	}else{
		$('#saveSO').removeAttr('disabled');
		$('#invalidQty').hide();
	}
	var unit = parseFloat($('#prodUntSO'+id).text()).toFixed(2);
	$('#prodCostSO'+id).text(parseFloat(qty*unit).toFixed(2));
	totalCostSO();
}
function totalCostSO(){
	var total=0;
	$('.cost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#SOTotalCost').text(total.toFixed(2));
	if(total = 0){
		$('#saveSO').addClass('hidden');
	}
}
function removeIA(id,prodId,index){
	var table = $('.product').DataTable();
	$('#SO'+id).remove();
	id +=1;
	if( $('#SO'+id).length ) 
	{
	  while(id<itemno){
			$('#SO'+id).attr('id','SO'+(id-1));
			$('#itemno'+(id)).attr('id','itemno'+(id-1));
			$('#itemno'+(id-1)).text(id-1);
			$('#productId'+id).attr('id','productId'+(id-1));
			$('#removeSO'+(id)).attr('id','removeSO'+(id-1));
			prodId = $('#productId'+(id-1)).text();
			index = table.row('#rowProd'+prodId).index();
			$('#removeSO'+(id-1)).attr('onclick','removeSO('+(id-1)+','+prodId+','+index+')');
			id++;
		}
	}
	itemno -=1;
	totalCostSO();
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
function editIA(id){
	$('#vwSaveBtn').addClass('hidden');
	$('#editIAModal').modal('show');
	 $.post('/viewIA',{id:id},function(data){
	 	$('#edIAId').text(data[0]['id']);
	 	$('#edIADate').text(data[0]['AdjustmentDate']);
	 	$('select#branch option[value="'+data[0]['BranchNo']+'"]').attr('selected',true);
	 	$('#remarks').text(data[0]['Remarks']);
	 	$('#edPreparedBy').val(data[0]['PreparedBy']);
	 	if(data[0]['ApprovedBy'] == ''){
	 		$('#edApprovedBy').val('N/A');
	 	}else{
	 		$('#edApprovedBy').val(data[0]['ApprovedBy']);
	 	}
	      });
	 $.post('/viewIADetails',{id:id},function(data){
	  			$(".edSOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
	  			// var ExpiryDate = substring(value.)
			  		$.each(data, function(key,value) {
			  		if (value.Unit == 'box' || value.Unit == 'Box'){
			  			var nxtUnit = 'Pcs';
			  		}else if (value.Unit == 'pcs' || value.Unit == 'Pcs'){
			  			var nxtUnit = 'Box';
			  		}
			  		var itemCost = parseFloat(value.CostPerQty)*parseFloat(value.Qty);
	  				$('.edSOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+value.ProductNo+'">'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td>
	  					<td class="editable-default" id="lotNo'+id+'"><i>'+value.LotNo+'</i></td>
						<td class="dateEditable">'+value.ExpiryDate+'</td>
	  					<td><select class="form-control square" name="unit" id="unit">
		                  <option value="'+value.Unit+'">'+value.Unit+'</option>
		                  <option value="'+nxtUnit+'">'+nxtUnit+'</option>
		                </select></td>
	  					<td class="vweditable" id="edQty'+counter+'">'+parseInt(value.Qty)+'</td>
	  					<td class="vweditable" id="edUnt'+counter+'">'+money(value.CostPerQty)+'</td>
	  					<td class="cost"id="edCost'+counter+'">'+itemCost.toFixed(2)+'</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
		  			total+=value.CostPerQty*value.Qty;
	  				// editable(value.ProductNo);
		  			counter+=1;
		  			$('.editable-default').editable({
						send: 'never', 
					    type: 'text',
					    value:value.LotNo,
					    validate: function(value) {
					        if($.trim(value) == '') {
					         return 'This field is required';
					        }
					    },
					    emptytext:0,
					   display: function(value) {
					   	$(this).text(value);
					  	}	
					});
					$('.dateEditable').editable({
					type: 'combodate',
				        format: 'YYYY-MM-DD',    
				        viewformat: 'YYYY-MM-DD',    
				        template: 'D / MMMM / YYYY',
					    validate: function(value) {
					        if($.trim(value) == '') {
					         return 'This field is required';
					        }
					    },    
				        combodate: {
				                minYear: d.getFullYear(),
				                maxYear: d.getFullYear()+10,
				                minuteStep: 1
				           }
			    	});
		  			$('.vweditable').editable({
						send: 'never', 
					    type: 'text',
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
					   		var rowID = $(this).attr('id').substring(5);
					   		// alert(rowID);
					        edcalcCost(rowID);
							}
					});
				});
				// $('#edSOTotalCost').text(money(parseFloat(total)));
				function edcalcCost(id){
					// alert(id);
					var qty = $('#edQty'+id).text();
					var unit = $('#edUnt'+id).text();
					$('#edCost'+id).text(money(parseFloat(qty*unit)));
					edtotalCost();
				}
				function edtotalCost(){
					var total=0;
					$('.cost').each(function(){
						total += parseFloat($(this).text()); 
					});
					$('#edSOTotalCost').text(money(parseFloat(total)));
					if(total == 0){
						$('#vwSaveSOBtn').addClass('hidden');
					}else{
						$('#vwSaveSOBtn').removeClass('hidden');
					}
				}
	      });
}
function vwaddIA(id){
	var name= $('#name'+id).text();
	var brand= $('#brand'+id).text();
	var unit= $('#wholesale'+id).text();
	var table = $('.product').DataTable();
	var unitPrice = 0.00;
	var index=table.row('#rowProd'+id).index();
	var curDate = new Date();
	$('.edSOTable').append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>
		<td id="prdoNo'+itemno+'">'+id+'</td>
		<td>'+name+'</td>
		<td>'+brand+'</td>
		<td class="editable-default" id="lotNo'+id+'"><i></i></td>
		<td class="dateEditable">'+curDate.getFullYear()+'-'+curDate.getMonth()+'-'+curDate.getDate()+'
		</td>
		<td><select class="form-control square" name="unit" id="unit'+itemno+'">
                  <option value="'+unit+'">'+unit+'</option>
                  <option value="pcs">pcs</option>
                </select></td>
		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">'+1+'</td>
		<td class="light-red ed" id="prodUntSO'+itemno+'">0.00</td>
		<td class="cost" id="prodCostSO'+itemno+'">0.00</td>
		<td><button class="btn btn-danger btn-xs square" id="removeIA'+itemno+'" onclick="removeIA('+itemno+','+id+','+index+')">
		<i class="fa fa-times"></i> Remove</button></td></tr>');
		
		itemno +=1;
		// table.cell( index, 5 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
		// var unitAvailable = $('#unitAv'+id).val();
		$('.editable-default').editable({
				send: 'never', 
			    type: 'text',
			    value:1,
			    validate: function(value) {
			        if($.trim(value) == '') {
			         return 'This field is required';
			        }
			    },
			    emptytext:0,
			   display: function(value) {
			   	$(this).text(value);
			  	}	
			});
		$('.dateEditable').editable({
		type: 'combodate',
	        format: 'YYYY-MM-DD',    
	        viewformat: 'YYYY-MM-DD',    
	        template: 'D / MMMM / YYYY',
		    validate: function(value) {
		        if($.trim(value) == '') {
		         return 'This field is required';
		        }
		    },    
	        combodate: {
	                minYear: d.getFullYear(),
	                maxYear: d.getFullYear()+10,
	                minuteStep: 1
	           }
    	});
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
			   		var rowID = $(this).attr('id').substring(9);
			        edcalcCostSO(rowID);
			  	}	
			});
		$('.ed').editable({
				send: 'never', 
			    type: 'text',
			    value:unitPrice,
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
			   		var rowID = $(this).attr('id').substring(9);
			   		// alert(rowID);
			         edcalcCostSO(rowID);
					}
				});
		$('#vwSaveSOBtn').removeClass('hidden');
}
function edcalcCostSO(id){
	var qty = parseInt($('#prodQtySO'+id).text());
	var unit = parseFloat($('#prodUntSO'+id).text()).toFixed(2);
	$('#prodCostSO'+id).text(parseFloat(qty*unit).toFixed(2));
	edtotalCostSO();
}
function edtotalCostSO(){
	var total=0;
	$('.cost').each(function(){
		total += parseFloat($(this).text());
	});
	$('#edSOTotalCost').text(money(parseFloat(total)));
	if(total = 0){
		$('#vwSaveSOBtn').addClass('hidden');
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
	$('#vwSaveSOBtn').removeClass('hidden');
}
// END OF PO FUNCTIONS

$(document).ready(function() {
	$('#customer').on('change', function() {
		var id = $(this).val();
		$.post(reroute+'/fetchCustomerSI',{id:id},function(data){
			if(data){
				$('#SITable').find('tr').remove().end();
				var terms;
				$.each(data, function(key,value) {
					if (value.Terms == 0) {
                      terms = "Cash";
                    }else{
                      terms = "Check";
                    }
					$('#SITable').append('
						<tr id="rowProd'+value.id+'">
	                      <td id="si'+value.id+'">'+value.id+'</td>
	                      <td id="invoice'+value.id+'">'+value.SalesInvoiceRefDocNo+'</td>
	                      <td id="SO'+value.id+'">'+value.SalesOrderNo+'</td>
	                      <td id="invoiceDate'+value.id+'">'+value.InvoiceDate+'</td>
	                      <td id="terms'+value.id+'">'+terms+'</td>
	                      <td id="prepared'+value.id+'">'+value.PreparedBy+'</td>
	                      <td id="approved'+value.id+'">'+value.ApprovedBy+'</td>
	                      <td><button class="btn btn-success btn-xs square" onclick="addCR('+value.id+')" ><i class="fa fa-check-circle"></i> Add</button>
	                      </td>
	                    </tr>
					');
				});
			}
		});
	});
	$('#addProductPO').click(function(){
		$('#addProductPOModal').modal('show');
	});
	//SAVE SO
	$('#saveSO').click(function(){
		var TableData;
		var SalesinvoiceNo = $('#SalesInvoiceNo').val();
		var CustomerNo = $('#customer').val();
		var Remarks = $('#remarks').val();
		TableData = storeTblValues();
		TableData = $.toJSON(TableData);
		// alert(TableData);
		// return false;
		var PreparedBy= $('#preparedBy').text();
			if($('#approved').is(':checked')){
			var approvedBy=PreparedBy;
		} else{
			var approvedBy='';
		}
		$.post(reroute+'/saveCR',{TD:TableData,CustomerNo:CustomerNo,SalesinvoiceNo:SalesinvoiceNo,Remarks:Remarks,PreparedBy:PreparedBy,approvedBy:approvedBy},function(data){
				if(data==1){
					// alert(data);
					location.reload();
					 $(location).attr('href','/customer-return#showCRList');
					 // $('.SOsaved').show().fadeOut(5000);
				}else if(data==0){
					$('#savePOError').fadeIn("fast", function(){        
				        $("#savePOError").fadeOut(4000);
				    });
				}
			});
		function storeTblValues()
		{
			var TableData = new Array();
			var ctr = 1;
			$('.IAtable tr').each(function(row, tr){
			    TableData[row]={
			        "ProdNo" : $(tr).find('td:eq(1)').text()
			        , "LotNo" : $(tr).find('td:eq(4)').text()
			        , "ExpiryDate" : $(tr).find('td:eq(5)').text()
			        , "Unit" : $(tr).find('td:eq(6)').text()
			        , "Qty" : $(tr).find('td:eq(7)').text()
			        , "UnitPrice" : $(tr).find('td:eq(8)').text()
			        , "FreebiesQty" : $(tr).find('td:eq(10)').text()
			        , "FreebiesUnit" : $(tr).find('td:eq(11)').text()
			    }
			    ctr++;
			});
			TableData.shift();
		    return TableData;
		}
	});
	$('#vwSaveSOBtn').click(function(){
		var TableData;
		var id = $('#edIAId').text();
		var BranchNo = $('#branch').val();
		var Remarks = $('#remarks').val();
		TableData = storeTblValues();
		TableData = $.toJSON(TableData);
		var PreparedBy= $('#preparedBy').text();
			if($('#approved').is(':checked')){
			var approvedBy=PreparedBy;
		} else{
			var approvedBy='';
		}
		$.post('/saveEditedIA',{TD:TableData,BranchNo:BranchNo,Remarks:Remarks,PreparedBy:PreparedBy,approvedBy:approvedBy,id:id},function(data){
				if(data==1){
					// alert(data);
					location.reload();
					 $(location).attr('href','/inventory-adjustment#showIAList');
					 // $('.SOsaved').show().fadeOut(5000);
				}else if(data==0){
					$('#savePOError').fadeIn("fast", function(){        
				        $("#savePOError").fadeOut(4000);
				    });
				}
			});
		function storeTblValues()
		{
			var TableData = new Array();
			var ctr = 1;
			$('.edSOTable tr').each(function(row, tr){
			    TableData[row]={
			        "ProdNo" : $(tr).find('td:eq(1)').text()
			        , "LotNo" : $(tr).find('td:eq(4)').text()
			        , "ExpiryDate" : $(tr).find('td:eq(5)').text()
			        , "Unit" : $(tr).find('td:eq(6) select option:selected').val()
			        , "Qty" : $(tr).find('td:eq(7)').text()
			        , "CostPerQty" : $(tr).find('td:eq(8)').text()
			    }
			    ctr++;
			});
			TableData.shift();
		    return TableData;
		}
	});
	$('#td-remarks').hover(function() {
		// alert('try');
		$(this).popover('show');
	}, function() {
		$(this).popover('hide');
	});
});