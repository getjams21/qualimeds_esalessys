$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
});
$(document).ready(function(){
		
	//sidebar collapse
	var a = document.title;
	document.getElementsByTagName("body")[0].id = a;
//navigation automatic dropdown
		$('ul.nav li.dropdown').hover(function() {
			$('.dropdown-menu', this).fadeIn();
		}, function() {
			$('.dropdown-menu', this).fadeOut('fast');
		});
//set active navbar
	$("#"+a+" a:contains('"+a+"')").parent().addClass('active');
	//$("#Edit a:contains('Profile')").parent().addClass('active');
//set active sidebar
		$("#"+a+" a:contains("+a+")").parent().addClass('active');
		$(".sidehead ul:contains("+a+")").removeClass('collapse');

	$("#sidebar-wrapper").hover(function(e) {
	        e.preventDefault();
	        $("#wrapper").addClass("toggled");
	    }, function() {
		$("#wrapper").removeClass('toggled');
	});	
	$('#ProductCategory').keyup(function(){
		$('#catError').addClass('hidden');
	});
	$('#saveCategory').click(function(e){
			e.preventDefault(); 
	      var category=jQuery.trim($('#ProductCategory').val());
	      if((!category) || category.length == 0){
	      	$('#catError').text('Category text field is empty!');
	      	$('#catError').removeClass('hidden');
	      }else{
	      	  var table=  $('.category').dataTable(); 
		 	  $.post('/addCategory',{cat:category},function(data){
		 	  	if(data == 0){
		 	  		$('#catError').text('Category already exists!');
	      			$('#catError').removeClass('hidden');
		 	  	}else{
			 	  	var rowIndex= table.fnAddData([
			               data['id'],data['ProdCatName'],'<button class="btn btn-success btn-xs" onclick="editCategory('+data['id']+');"><i class="fa fa-cog"></i> Edit</button>'
			        ]);
			        var row = table.fnGetNodes(rowIndex);
			        var thisRow= $(row).attr( 'id', 'category'+data['id'] );
			        $(' td:nth-child(1)').attr( 'id', 'catName'+data['id'] );
			        $('#catError').addClass('hidden');
		        }
		      });
	      }
	      $('#ProductCategory').val(' ');
	});
$('#categoryBtn').click(function(){
	var table = $('.category').DataTable();
	var id= $('#catID').val();
	var index = $('#catIndex').val();
	var catName = $('#txtCatName').val();
	var category=jQuery.trim($('#txtCatName').val());
      if((!category) || category.length == 0){
      	$('#modalCatError').text('Text field is empty!');
      	$('#modalCatError').removeClass('hidden');
      }else{
      		$.post('/editCategory',{id:id,catName:catName},function(data){
      			if(data == 0){
		 	  		$('#modalCatError').text('Category already exists!');
	      			$('#modalCatError').removeClass('hidden');
		 		}else{
			        table.cell( index, 1 ).data( data ).draw();
			        $('#myModal').modal('hide');
			    }
			});
	  }
});
$('#addSupplier').click(function(){
	$('.modal-title').text('Add new Supplier');
	$('#txtSupID').val(null);
	$('input[type=text]').val(null);
	$('#supplierModal').modal('show');

});
$('#addProduct').click(function(){
	$('.modal-title').text('Add new Product');
	$('#txtProdID').val(null);
	$('input[type=text]').val(null);
	$('#productModal').modal('show');

});
});
function editCategory(id){
	$('#modalCatError').addClass('hidden')
	var table = $('.category').DataTable();
	var catName= jQuery.trim($('#catName'+id).text());
	var index=table.row('#category'+id).index();
		$('#catID').val(id);
		$('#catIndex').val(index);
		$('#txtCatName').val(catName);
		$('#myModal').modal('show');
		$('.modal-title').text('Edit '+catName);
}


function editSupplier(id){
	var table=$('.supplier').DataTable();
			$('.modal-title').text('Edit Supplier');
	      	$('#supplierModal').modal('show');
		$.post('/fetchSupplier',{id:id},function(data){
			$('#txtSupID').val(data['id']);
	      	$('#SupplierName').val(data['SupplierName']);
	      	$('#Address').val(data['Address']);
	      	$('#Telephone1').val(data['Telephone1']);
	      	$('#Telephone2').val(data['Telephone2']);
	      	$('#ContactPerson').val(data['ContactPerson']);
		});

}
function editProduct(id){
	var table=$('.product').DataTable();
			$('.modal-title').text('Edit Product');
	      	$('#productModal').modal('show');
		$.post('/fetchProduct',{id:id},function(data){
			$('#txtProdID').val(data['id']);
	      	$('#ProductCatNo').val(data['ProductCatNo']);
	      	$('#ProductName').val(data['ProductCatNo']);
	      	$('#BrandName').val(data['BrandName']);
	      	$('#WholeSaleUnit').val(data['WholeSaleUnit']);
	      	$('#RetailUnit').val(data['RetailUnit']);
	      	$('#RetailQtyPerWholeSaleUnit').val(data['RetailQtyPerWholeSaleUnit']);
	      	$('#Markup1').val(data['Markup1']);
	      	$('#Markup2').val(data['Markup2']);
	      	$('#Markup3').val(data['Markup3']);
	      	$('#ActiveMarkup').val(data['ActiveMarkup']);
		});

}

// function getIndex(selector){
// 	var idx =table.row(selector).index();
// 	alert(idx);
// }
// function editColumnValue(index,cell,value){
// 	table.cell( index, cell ).data( value ).draw();
// }


// }
// function editable(table,id){
// 		var oTable=  $('.'+table).dataTable(); 
// 		$('.editable'+id, oTable.fnGetNodes()).editable( '/asdasd', {
// 				"callback": function( sValue, y ) {
// 					var aPos = oTable.fnGetPosition( this );
// 					oTable.fnUpdate( sValue, aPos[0], aPos[1] );
// 				},
// 				"submitdata": function ( value, settings ) {
// 					return {
// 						"row_id": this.parentNode.getAttribute('id'),
// 						"column": oTable.fnGetPosition( this )[2]
// 					};
// 				},
// 				"height": "14px"
// 			} );

// }
	
