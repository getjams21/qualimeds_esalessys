//PO FUNCTIONS
var itemno = 1;
var counter = 1;
function addSO(id){
	// alert('check');
	var prodNum = $('#prodId'+id).text();
	var name= $('#name'+id).text();
	var brand= $('#brand'+id).text();
	var unit= $('#unit'+id).text();
	var table = $('.product').DataTable();
	var LotNo = $('#lotNo'+id).text();
	var ExpiryDate = $('#ExpDate'+id).val();
	var unitQty = $('#unitQty'+id).text();
	var unitQtyR = $('#unitQtyR'+id).val();
	var unitPrice = $('#unitPrice'+id).text();
	var index=table.row('#rowProd'+id).index();
	var curDate = new Date();
	$('.SOtable').append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>
		<td id="prdoNo'+itemno+'">'+prodNum+'</td>
		<td>'+name+'</td>
		<td>'+brand+'</td>
		<td>'+LotNo+'</td>
		<td>'+ExpiryDate+'</td>
		<td><select class="form-control square" name="unit" id="unit'+itemno+'">
                  <option value="'+unit+'">'+unit+'</option>
                  <option value="pcs">pcs</option>
                </select></td>
        <input id="unitAv'+id+'" type="hidden" value="'+unitQty+'">
        <input id="unitAvR'+id+'" type="hidden" value="'+unitQtyR+'">
		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">'+1+'</td>
		<td class="light-red ed" id="prodUntSO'+itemno+'" value="'+unitPrice+'">'+unitPrice+'</td>
		<td class="cost" id="prodCostSO'+itemno+'">0.00</td>
		<td><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+','+id+','+index+')">
		<i class="fa fa-times"></i> Remove</button></td></tr>');
		var unitAvailable = $('#unitAv'+id).val();
		$('select[id=unit'+itemno+']').on('change', function() {
			// alert($('select[id=unit'+id+']').val());
			if($(this).val() == 'pcs'){
				unitAvailable = $('#unitAvR'+id).val();
				$('#prodQtySO'+itemno).text('1');
			}else{
				// alert('sulod');
				unitAvailable = $('#unitAv'+id).val();
				$('#prodQtySO'+itemno).text('1');
				$('#unitQty'+id).text(unitQty);
			}
		});
		itemno +=1;
		table.cell( index, 8 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
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
		   		if (parseFloat(value) <= parseFloat(unitAvailable)){
		   			$('#invalidQty').hide();
		   			$(this).text(value);
			   		var rowID = $(this).attr('id').substring(9);
			   		// alert(rowID);
			         calcCostSO(rowID);
				}
				else{
					// alert('test');
					$(this).text('1');
		   			$('#invalidQty').show();
		   		}
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
			         calcCostSO(rowID);
					}
				});
		$('#saveSO').removeClass('hidden');
}
function calcCostSO(id){
	var qty = parseInt($('#prodQtySO'+id).text());
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
function removeSO(id,prodId,index){
	var table = $('.product').DataTable();
		table.cell( index, 8 ).data('<button class="btn btn-success btn-xs square" 
			onclick="addSO('+prodId+')" >
			<i class="fa fa-check-circle"></i> Add</button>').draw();
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
function editSO(id){
	$('#vwSaveBtn').addClass('hidden');
	$('#editSOModal').modal('show');
	 $.post('/viewSO',{id:id},function(data){
	 	// alert(data[0]['id']);
	 	$('#edSOId').text(data[0]['id']);
	 	$('#edSODate').text(data[0]['SalesOrderDate']);
	 	$('[name="vwCustomer"]').val(data[0]['CustomerNo']);
	 	// $('[id="medReps"]').prop('selected',true);
	 	$('select#medReps option[value="'+data[0]['UserNo']+'"]').attr('selected',true);
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
	 $.post('/viewSODetails',{id:id},function(data){
	  			$(".edSOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
			  		if (value.Unit == 'box' || value.Unit == 'Box'){
			  			var nxtUnit = 'Pcs';
			  		}else if (value.Unit == 'pcs' || value.Unit == 'Pcs'){
			  			var nxtUnit = 'Box';
			  		}
	  				$('.edSOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+value.ProductNo+'">'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td>
	  					<td>'+value.LotNo+'</td>
						<td>'+value.ExpiryDate+'</td>
	  					<td><select class="form-control square" name="unit" id="unit'+counter+'">
		                  <option value="'+value.Unit+'">'+value.Unit+'</option>
		                  <option value="'+nxtUnit+'">'+nxtUnit+'</option>
		                </select></td>
	  					<td class="vweditable" id="edQty'+counter+'">'+value.Qty+'</td>
	  					<td class="vwEd" id="edUnt'+counter+'">'+money(value.UnitPrice)+'</td>
	  					<td class="ecost"id="edCost'+counter+'">'+(money(value.UnitPrice*value.Qty))+'</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
		  			total+=value.UnitPrice*value.Qty;
		  	// 		var unitAvailable = $('#unitAv'+counter).val();
					// $('select[id=unit'+counter+']').on('change', function() {
					// 	// alert($('select[id=unit'+id+']').val());
					// 	if($(this).val() == 'pcs'){
					// 		unitAvailable = $('#unitAvR'+id).val();
					// 		$('#prodQtySO'+itemno).text('1');
					// 		// alert(id);
					// 		// $('#unitQty'+id).hide();
					// 	}else{
					// 		// alert('sulod');
					// 		unitAvailable = $('#unitAv'+id).val();
					// 		$('#prodQtySO'+itemno).text('1');
					// 		$('#unitQty'+id).text(unitQty);
					// 	}
					// });
		  			counter+=1;
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
					        edcalcCost(rowID);
							}
					});
					$('.vwEd').editable({
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
					        edcalcCost(rowID);
							}
					});
				});
				$('#edSOTotalCost').text(total);
				function edcalcCost(id){
					// alert(id);
					var qty = $('#edQty'+id).text();
					var unit = $('#edUnt'+id).text();
					// alert(unit);
					$('#edCost'+id).text(parseFloat(qty*unit));
					edtotalCost();
				}
				function edtotalCost(){
					var total=0;
					$('.ecost').each(function(){
						total += parseFloat($(this).text()); 
					});
					$('#edSOTotalCost').text(money(total));
					if(total == 0){
						$('#vwSaveSOBtn').addClass('hidden');
					}else{
						$('#vwSaveSOBtn').removeClass('hidden');
					}
				}
	      });
}
function vwaddSO(id){
	var prodNum = $('#prodId'+id).text();
	var name= $('#name'+id).text();
	var brand= $('#brand'+id).text();
	var unit= $('#unit'+id).text();
	var table = $('.product').DataTable();
	var LotNo = $('#lotNo'+id).text();
	var ExpiryDate = $('#ExpDate'+id).val();
	var unitQty = $('#unitQty'+id).text();
	var unitQtyR = $('#unitQtyR'+id).val();
	var unitPrice = $('#unitPrice'+id).text();
	var index=table.row('#rowProd'+id).index();
	var curDate = new Date();
	$('.edSOTable').append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td>
		<td id="prdoNo'+itemno+'">'+prodNum+'</td>
		<td>'+name+'</td>
		<td>'+brand+'</td>
		<td>'+LotNo+'</td>
		<td>'+ExpiryDate+'</td>
		<td><select class="form-control square" name="unit" id="unit'+itemno+'">
                  <option value="'+unit+'">'+unit+'</option>
                  <option value="pcs">pcs</option>
                </select></td>
        <input id="unitAv'+id+'" type="hidden" value="'+unitQty+'">
        <input id="unitAvR'+id+'" type="hidden" value="'+unitQtyR+'">
		<td class="light-green editable" id="prodQtySO'+itemno+'" value="'+itemno+'">'+1+'</td>
		<td class="light-red ed" id="prodUntSO'+itemno+'" value="'+unitPrice+'">'+unitPrice+'</td>
		<td class="ecost" id="prodCostSO'+itemno+'">0.00</td>
		<td><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+','+id+','+index+')">
		<i class="fa fa-times"></i> Remove</button></td></tr>');
		var unitAvailable = $('#unitAv'+id).val();
		$('select[id=unit'+itemno+']').on('change', function() {
			// alert($('select[id=unit'+id+']').val());
			if($(this).val() == 'pcs'){
				unitAvailable = $('#unitAvR'+id).val();
				$('#prodQtySO'+itemno).text('1');
				// alert(id);
				// $('#unitQty'+id).hide();
			}else{
				// alert('sulod');
				unitAvailable = $('#unitAv'+id).val();
				$('#prodQtySO'+itemno).text('1');
				$('#unitQty'+id).text(unitQty);
			}
		});
		itemno +=1;
		table.cell( index, 8 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
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
		   		if (parseFloat(value) <= parseFloat(unitAvailable)){
		   			$('#invalidQty').hide();
		   			$(this).text(value);
			   		var rowID = $(this).attr('id').substring(9);
			   		// alert(rowID);
			         edcalcCostSO(rowID);
				}
				else{
					// alert('test');
					$(this).text('1');
		   			$('#invalidQty').show();
		   		}
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
		// $('#edSOTotalCost').text(total);
				function edcalcCost(id){
					// alert(id);
					var qty = $('#edQty'+id).text();
					var unit = $('#edUnt'+id).text();
					// alert(unit);
					$('#edCost'+id).text(parseFloat(qty*unit));
					edtotalCost();
				}
				function edtotalCost(){
					var total=0;
					$('.ecost').each(function(){
						total += parseFloat($(this).text()); 
					});
					$('#edSOTotalCost').text(money(total));
					if(total == 0){
						$('#vwSaveSOBtn').addClass('hidden');
					}else{
						$('#vwSaveSOBtn').removeClass('hidden');
					}
				}
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
	$('.ecost').each(function(){
		total += parseFloat($(this).text()); 
	});
	$('#edSOTotalCost').text(total.toFixed(2));
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
	$('#vwSavePOBtn').removeClass('hidden');
}
// END OF PO FUNCTIONS

$(document).ready(function() {
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
	//SAVE SO
	$('#saveSO').click(function(){
		var TableData;
		var CustomerNo = $('#customer').val();
		var term = $('#term').val();
		var UserNo = $('#medReps').val();
		TableData = storeTblValues();
		TableData = $.toJSON(TableData);
		// alert(TableData);
		var PreparedBy= $('#preparedBy').text();
			if($('#approved').is(':checked')){
			var approvedBy=PreparedBy;
		} else{
			var approvedBy='';
		}
		$.post('/saveSO',{TD:TableData,CustomerNo:CustomerNo,term:term,UserNo:UserNo,PreparedBy:PreparedBy,approvedBy:approvedBy},function(data){
				if(data==1){
					location.reload();
					 $(location).attr('href','/SalesOrders#showSOList');
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
			$('.SOtable tr').each(function(row, tr){
			    TableData[row]={
			        "ProdNo" : $(tr).find('td:eq(1)').text()
			        , "LotNo" : $(tr).find('td:eq(4)').text()
			        , "ExpiryDate" : $(tr).find('td:eq(5)').text()
			        , "Unit" : $(tr).find('td:eq(6) select option:selected').val()
			        , "Qty" : $(tr).find('td:eq(7)').text()
			        , "UnitPrice" : $(tr).find('td:eq(8)').text()
			    }
			    ctr++;
			});
			TableData.shift();
		    return TableData;
		}
	});
	$('#vwSaveSOBtn').click(function(){
		var TableData;
		var id = $('#edSOId').text();
		var customer = $('[name="vwCustomer"]').val();
		var UserNo = $('#medReps').val();
		var term = $('#edTerm').val();
		TableData = storeTblValues()
		TableData = $.toJSON(TableData);

		$.post('/saveEditedSO',{TD:TableData,customer:customer,UserNo:UserNo,term:term,id:id},function(data){
				if(data==1){
					location.reload();
				}else if(data==0){
					alert('invalid move');
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
			        , "UnitPrice" : $(tr).find('td:eq(8)').text()
			    }
			    ctr++;
			});
			TableData.shift();
		    return TableData;
		}
	});
});