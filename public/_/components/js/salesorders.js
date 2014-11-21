//PO FUNCTIONS
var itemno = 1;
var counter = 1;
function addSO(id){
	var name= $('#name'+id).text();
	var brand= $('#brand'+id).text();
	var unit= $('#unit'+id).text();
	var table = $('.product').DataTable();
	var index=table.row('#rowProd'+id).index();
	var curDate = new Date();
	$('.SOtable').append('<tr id="SO'+itemno+'"><td id="itemno'+itemno+'">'+itemno+'</td><td id="productId'+itemno+'">'+id+'</td>
		<td>'+name+'</td>
		<td>'+brand+'</td>
		<td>'+unit+'</td>
		<td class="light-green editable" id="prodQtySO'+id+'">'+1+'</td>
		<td class="light-red editable" id="prodUnitSO'+id+'"></td>
		<td class="cost" id="prodCostSO'+id+'">0.00</td>
		<td><button class="btn btn-danger btn-xs square" id="removeSO'+itemno+'" onclick="removeSO('+itemno+','+id+','+index+')">
		<i class="fa fa-times"></i> Remove</button></td></tr>');
	itemno +=1;
	table.cell( index, 4 ).data('<b class="success"> <i class="fa fa-check-circle"> Added</b>').draw();
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
			        calcCostSO(id);
					}
			});
		$('#saveSO').removeClass('hidden');
}
function calcCostSO(id){
	var qty = $('#prodQtySO'+id).text();
	var unit = $('#prodUnitSO'+id).text();
	$('#prodCostSO'+id).text(qty*unit);
	totalCostSO();
}
function totalCostSO(){
	var total=0;
	$('.cost').each(function(){
		total += parseInt($(this).text()); 
	});
	$('#SOTotalCost').text(total);
	if(total = 0){
		$('#saveSO').addClass('hidden');
	}
}
function removeSO(id,prodId,index){
	var table = $('.product').DataTable();
		table.cell( index, 4 ).data('<button class="btn btn-success btn-xs square" 
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
function editPO(id){
	$('#vwSaveBtn').addClass('hidden');
	$('#editPOModal').modal('show');
	 $.post('/viewPO',{id:id},function(data){
	 	$('#edPOId').text(data[0]['id']);
	 	$('#edPODate').text(data[0]['PODate']);
	 	$('[name="vwSupplier"]').val(data[0]['SupplierNo']);
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
	 $.post('/viewPODetails',{id:id},function(data){
	  			$(".edPOTable > tbody").html("");
	  			counter=1;
	  			var total=0;
			  		$.each(data, function(key,value) {
	  				$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+value.ProductNo+'">'+value.ProductNo+'</td>
	  					<td>'+value.ProductName+'</td>
	  					<td>'+value.BrandName+'</td><td>'+value.Unit+'</td><td class="vweditable" id="edQty'+value.ProductNo+'">'+value.Qty+'</td><td class="vweditable" id="edUnit'+value.ProductNo+'">'+value.CostPerQty+'</td>
	  					<td class="ecost"id="edCost'+value.ProductNo+'">'+(value.CostPerQty*value.Qty)+'</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
		  			total+=value.CostPerQty*value.Qty;
	  				editable(value.ProductNo);
		  			counter+=1;
	  				});
	  				$('#edTotalCost').text(total);
	      });
}
function editable(id){
	$('.vweditable').editable({
			send: 'never', 
		    type: 'text',
		    validate: function(value) {
		        if($.trim(value) == '') {
		         return 'This field is required';
		        }
		        else if($.isNumeric(value) == '' || value==0) {
		            return 'Please input a valid number greater than 0';
		        }else{
		        $('#vwSavePOBtn').removeClass('hidden');
		        }
		    },
		    emptytext:0,
		   display: function(value) {
		   		$(this).text(value);
		        edcalcCost(id);
				}
	});
}
function edcalcCost(id){
	var qty = $('#edQty'+id).text();
	var unit = $('#edUnit'+id).text();
	$('#edCost'+id).text(qty*unit);
	edtotalCost();
}
function edtotalCost(){
	var total=0;
	$('.ecost').each(function(){
		total += parseInt($(this).text()); 
	});
	$('#edPOTotalCost').text(total);
	if(total == 0){
		$('#vwSavePOBtn').addClass('hidden');
	}
}
function vwaddPO(id){
	var name= $('#vwname'+id).text();
	var brand= $('#vwbrand'+id).text();
	var unit= $('#vwunit'+id).text();
	var table = $('.vwproduct').DataTable();
	var index=table.row('#vwrowProd'+id).index();
	if($('#vwProd'+id).length){prodError
		 $('#prodError').fadeIn("fast", function(){        
	        $("#prodError").fadeOut(4000);
	    });
	}else{
	$('.edPOTable >tbody').append('<tr id="vwPO'+counter+'"><td id="vwItemno'+counter+'">'+counter+'</td><td id="vwProd'+id+'">'+id+'</td>
	  					<td>'+name+'</td>
	  					<td>'+brand+'</td><td>'+unit+'</td><td class="vweditable" id="edQty'+id+'">'+1+'</td><td class="vweditable" id="edUnit'+id+'">'+1+'</td>
	  					<td class="ecost"id="edCost'+id+'">1</td><td><button class="btn btn-danger 
	  					btn-xs square dis" id="vwRemovePO'+counter+'" onclick="vwRemovePO('+counter+')" >
						<i class="fa fa-times" ></i> Remove</button></td></tr>');
	
		counter +=1;
		editable(id);
		$('#vwSavePOBtn').removeClass('hidden');
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
		var customer = $('#customer').val();
		var term = $('#term').val();
		var UserNo = $('#medReps').val();
		TableData = storeTblValues()
		TableData = $.toJSON(TableData);
		// alert(TableData);
		$.post('/saveSO',{TD:TableData,customer:customer,term:term,UserNo:UserNo},function(data){
				if(data==1){
					// location.reload();
					 $('.SOsaved').show().fadeOut(5000);
				}else if(data==0){
					$('#savePOError').fadeIn("fast", function(){        
				        $("#savePOError").fadeOut(4000);
				    });
				}
			});
		function storeTblValues()
		{
			var TableData = new Array();
			$('.SOtable tr').each(function(row, tr){
			    TableData[row]={
			        "ProdNo" : $(tr).find('td:eq(1)').text()
			        , "Unit" :$(tr).find('td:eq(4)').text()
			        , "Qty" : $(tr).find('td:eq(5)').text()
			        , "UnitPrice" : $(tr).find('td:eq(6)').text()
			    }
			});
			TableData.shift();
		    return TableData;
		}
	});
	$('#vwSavePOBtn').click(function(){
		var TableData;
		var id = $('#edPOId').text();
		var supplier = $('[name="vwSupplier"]').val();
		var term = $('#edTerm').val();
		TableData = storeTblValues()
		TableData = $.toJSON(TableData);

		$.post('/saveEditedPO',{TD:TableData,supplier:supplier,term:term,id:id},function(data){
				if(data==1){
					location.reload();
				}else if(data==0){
					alert('invalid move');
				}
			});
		function storeTblValues()
		{
			var TableData = new Array();
			$('.edPOTable tr').each(function(row, tr){
			    TableData[row]={
			        "ProdNo" : $(tr).find('td:eq(1)').text()
			        , "Unit" :$(tr).find('td:eq(4)').text()
			        , "Qty" : $(tr).find('td:eq(5)').text()
			        , "CostPerQty" : $(tr).find('td:eq(6)').text()
			    }
			});
			TableData.shift();
		    return TableData;
		}
	});
});