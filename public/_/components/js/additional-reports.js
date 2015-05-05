var reroute='/user/'+$('meta[name="_token"]').attr('content');
function showMonthlySalesReport(medRep){
	var from = $('#min').val();
	var to = $('#max').val();

	$.post(reroute+'/get-monthly-sales-report', {from:from,to:to,medRep:medRep}).done(function(data) {
		if(data){
			$('#reportsTable').find('thead').remove().end();
			$('#reportsTable').find('tbody').remove().end();
			$('#reportsTable').append('
				<thead>
		          <tr>
		            <th>Transaction</th>
		            <th>Sales Rep</th>
		            <th>Transaction Date</th>
		            <th>Customer</th>
		            <th>Sales Invoice RefDoc No</th>
		            <th>Remarks</th>
		            <th>Amount</th>
		          </tr>
		        </thead>
		        <tbody id="tableData">
		        </tbody>
			');
			$.each(data, function(key,value) {
				$('#tableData').append('
					<tr>
						<td>'+value.Trans+'</td>
						<td>'+value.SalesRep+'</td>
						<td>'+value.TransDate+'</td>
						<td>'+value.CustomerName+'</td>
						<td>'+value.SalesInvoiceRefDocNo+'</td>
						<td>'+value.Remarks+'</td>
						<td>'+money(value.Amount)+'</td>
					</tr>
				');
		    });
		    
		    $('#add_report_type').val(1);
		   
		}
		
	});
}
//Monthly Collection Reports
function showMonthlyCollectionReport(medRep){
	var from = $('#min').val();
	var to = $('#max').val();

	$.post(reroute+'/get-monthly-collection-report', {from:from,to:to,medRep:medRep}).done(function(data) {
		if(data){
			$('#reportsTable').find('thead').remove().end();
			$('#reportsTable').find('tbody').remove().end();
			$('#reportsTable').append('
				<thead>
		          <tr>
		          	<th>Sales Rep</th>	
		            <th>OR Number</th>
		            <th>Customer</th>
		            <th>Payment Date</th>
		            <th>Check No</th>
		            <th>Check Due Date</th>
		            <th>Amount</th>
		          </tr>
		        </thead>
		        <tbody id="tableData">
		        </tbody>
			');
			$.each(data, function(key,value) {
				$('#tableData').append('
					<tr>
						<td>'+value.SalesRep+'</td>
						<td>'+value.ORnumber+'</td>
						<td>'+value.CustomerName+'</td>
						<td>'+value.PaymentDate+'</td>
						<td>'+value.CheckNo+'</td>
						<td>'+value.CheckDueDate+'</td>
						<td>'+money(value.Amount)+'</td>
					</tr>
				');
		    });
		    
		    $('#add_report_type').val(1);
		   
		}else{
			return false;
		}
		
	});
}

jQuery(document).ready(function($) {
	$('#add_report_type,#min,#max,#medReps').change(function(event) {
		var medRep = $('#medReps').val();
		if($('#add_report_type').val() == 1){
			showMonthlySalesReport(medRep);
		}else if($('#add_report_type').val() == 2){
			showMonthlyCollectionReport(medRep);
		}
	});
	 $('#reportPrint').click(function(){
			$("#printable").printThis({
			     debug: false,             
			     importCSS: false,           
			     printContainer: true,       
			     pageTitle: "Reports",              
			     removeInline: false,        
			     printDelay: 333,           
			     header: null,              
			     formValues: true,
			     page:'A3',
			     margins:'none'           
			  });
			});
});