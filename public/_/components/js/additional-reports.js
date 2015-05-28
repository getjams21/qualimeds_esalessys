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
		            <th>Invoice No.</th>
		            <th>Amount</th>
		          </tr>
		        </thead>
		        <tbody id="tableData">
		        </tbody>
			');
			var total = 0;
			$.each(data, function(key,value) {
				total += parseFloat(value.Amount);
				$('#tableData').append('
					<tr>
						<td>'+value.Trans+'</td>
						<td>'+value.SalesRep+'</td>
						<td>'+value.TransDate+'</td>
						<td>'+value.CustomerName+'</td>
						<td>'+value.SalesInvoiceRefDocNo+'</td>
						<td>'+cmoney(value.Amount)+'</td>
					</tr>
				');
		    });
		    $('#tableData').append('
		    	<tr>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(total)+'</span></label>
			        </td>
		        </tr>
		    ');
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
			var total = 0;
			$.each(data, function(key,value) {
				total += parseFloat(value.Amount);
				var ORnumber = value.ORnumber;
				var checkNo = value.CheckNo;
				var CheckDueDate = value.CheckDueDate;

				if (ORnumber == null){
					ORnumber = '';
				}
				if(checkNo == null){
					checkNo = '';
				}
				if(CheckDueDate == null){
					CheckDueDate = '';
				}

				$('#tableData').append('
					<tr>
						<td>'+value.SalesRep+'</td>
						<td>'+ORnumber+'</td>
						<td>'+value.CustomerName+'</td>
						<td>'+value.PaymentDate+'</td>
						<td>'+checkNo+'</td>
						<td>'+CheckDueDate+'</td>
						<td>'+money(value.Amount)+'</td>
					</tr>
				');
		    });
		    $('#tableData').append('
		    	<tr>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(total)+'</span></label>
			        </td>
		        </tr>
		    ');
		   
		}else{
			return false;
		}
		
	});
}
//Monthly Bad Accounts
function showBadAccounts(medRep){
	var from = $('#min').val();
	var to = $('#max').val();
	$.post(reroute+'/get-bad-accounts', {from:from,to:to,medRep:medRep}).done(function(data) {
		if(data){
			$('#reportsTable').find('thead').remove().end();
			$('#reportsTable').find('tbody').remove().end();
			$('#reportsTable').append('
				<thead>
		          <tr>
		          	<th>Invoice No.</th>	
		            <th>Customer</th>
		            <th>Sales Rep</th>
		            <th>Invoice Date</th>
		            <th>Within 30 Days</th>
		            <th>More than 30 Days</th>
		            <th>More than 60 Days</th>
		            <th>More than 90 Days</th>
		            <th>More than 120 Days</th>
		            <th>More than 150 Days</th>
		          </tr>
		        </thead>
		        <tbody id="tableData">
		        </tbody>
			');
			var within30Daystotal = 0;
			var morethan30DaysTotal = 0;
			var morethan60DaysTotal = 0;
			var morethan90DaysTotal = 0;
			var morethan120DaysTotal = 0;
			var morethan150DaysTotal = 0;
			$.each(data, function(key,value) {
				// total += parseFloat(value.Amount);
				within30Daystotal += parseFloat(value.Within30Days);
				morethan30DaysTotal += parseFloat(value.MoreThan30Days);
				morethan60DaysTotal += parseFloat(value.MoreThan60Days);
				morethan90DaysTotal += parseFloat(value.MoreThan90Days);
				morethan120DaysTotal += parseFloat(value.MoreThan120Days);
				morethan150DaysTotal += parseFloat(value.MoreThan150Days);
				$('#tableData').append('
					<tr>
						<td>'+value.SalesInvoiceRefDocNo+'</td>
						<td>'+value.CustomerNo+'</td>
						<td>'+value.UserNo+'</td>
						<td>'+value.InvoiceDate+'</td>
						<td>'+cmoney(value.Within30Days)+'</td>
						<td>'+cmoney(value.MoreThan30Days)+'</td>
						<td>'+cmoney(value.MoreThan60Days)+'</td>
						<td>'+cmoney(value.MoreThan90Days)+'</td>
						<td>'+cmoney(value.MoreThan120Days)+'</td>
						<td>'+cmoney(value.MoreThan150Days)+'</td>
					</tr>
				');
		    });
		    $('#tableData').append('
		    	<tr>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td><label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(within30Daystotal)+'</span></label></td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(morethan30DaysTotal)+'</span></label>
			        </td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(morethan60DaysTotal)+'</span></label>
			        </td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(morethan90DaysTotal)+'</span></label>
			        </td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(morethan120DaysTotal)+'</span></label>
			        </td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total:&nbsp;
				        <span id="total">'+cmoney(morethan150DaysTotal)+'</span></label>
			        </td>
		        </tr>
		    ');
		   
		}else{
			return false;
		}
		
	});
}
//Receivables Reports
function showReceivables(medRep){
	var from = $('#min').val();
	var to = $('#max').val();

	$.post(reroute+'/get-receivable-report', {from:from,to:to,medRep:medRep}).done(function(data) {
		if(data){
			$('#reportsTable').find('thead').remove().end();
			$('#reportsTable').find('tbody').remove().end();
			$('#reportsTable').append('
				<thead>
		          <tr>
		          	<th>Sales Rep</th>	
		            <th>Customer</th>
		            <th>Total Sales</th>
		            <th>Credit Memo</th>
		            <th>Total Payment</th>
		            <th>Balance</th>
		          </tr>
		        </thead>
		        <tbody id="tableData">
		        </tbody>
			');
			var totalSales = 0;
			var totalBalance = 0;
			var totalPayment = 0;
			$.each(data, function(key,value) {
				totalSales += parseFloat(value.TotalSAles);
				totalBalance += parseFloat(value.Balance);
				totalPayment += parseFloat(value.TotalPayment);
				$('#tableData').append('
					<tr>
						<td>'+value.SalesRep+'</td>
						<td>'+value.CustomerName+'</td>
						<td>'+cmoney(value.TotalSAles)+'</td>
						<td>'+cmoney(value.CreditMemo)+'</td>
						<td>'+cmoney(value.TotalPayment)+'</td>
						<td>'+cmoney(value.Balance)+'</td>
					</tr>
				');
		    });
		    $('#tableData').append('
		    	<tr>
		    		<td></td>
		    		<td></td>
		    		<td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total Sales:&nbsp;
				        <span id="total">'+cmoney(totalSales)+'</span></label>
			        </td>
		    		<td></td>
		    		<td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total Payment:&nbsp;
				        <span id="total">'+cmoney(totalPayment)+'</span></label>
			        </td>
			        <td>
				        <label class="pull-left" style="margin-right:30px;" id="lblTotal">Total Balance:&nbsp;
				        <span id="total">'+cmoney(totalBalance)+'</span></label>
			        </td>
		        </tr>
		    ');
		   
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
		}else if($('#add_report_type').val() == 3){
			showBadAccounts(medRep);
		}else if($('#add_report_type').val() == 4){
			showReceivables(medRep);
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