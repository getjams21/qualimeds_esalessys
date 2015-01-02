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

Route::get('/', ['as'=>'home', function(){
	return Redirect::to('/dashboard');
}])->before('auth');
// Reroute generic links to the correct user paths (from /a to /a/{uid})
Route::get('{path}', ['before' => 'auth|reroute']);

#AUTH GET ROUTES
Route::group(["before" => "auth", 'prefix' => 'user/'.Auth::user()->id], function() {
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
 		#BILLPAYMENTS
 		Route::get('/BillPayments', 'BillPaymentsController@index');
 		#SI
 		Route::get('/SalesInvoice', 'SalesInvoiceController@index');
 		#SP
 		Route::get('/SalesPayment', 'SalesPaymentController@index');
 		#IA
 		Route::get('/inventory-adjustment', 'IAController@index');
		#ST
 		Route::get('/stocks-transfer', 'STController@index');
});
/*
 * #ADMIN GET ROUTES
 */
Route::group(["before" => "admin", 'prefix' => 'user/'.Auth::user()->id], function() {
	#Product Categories
	Route::get('/ProductCategories', 'ProductCategoriesController@index');
	#Suppliers
	Route::get('/Suppliers', 'SuppliersController@index');
	#Products
	Route::get('/Products', 'ProductsController@index');
	#Banks
	Route::get('/banks', 'BanksController@index');
	#Brancher
	Route::get('/branches', 'BranchesController@index');
	#Customers
	Route::get('/customers', 'CustomersController@index');
	#Users
	Route::get('/Users', 'UsersController@index');
	Route::get('/toEditUser','UsersController@toEditUser');
	Route::get('delete-user/{id}', 'UsersController@destroy');
	Route::get('/verifyCurrentPassword', 'UsersController@validateCurrentPassword');
});


#AUTH POST ROUTES
Route::group(["before" => "auth"], function() {
	#Transactions
 	#PURCHASE ORDER ROUTES
 		Route::post('/savePO', 'POController@savePO');
 		Route::post('/viewPO', 'POController@viewPO');
 		Route::post('/viewPODetails', 'POController@viewPODetails');
 		Route::post('/saveEditedPO', 'POController@saveEditedPO');
 		Route::post('/approvePO', 'POController@approvePO');
 		Route::post('/cancelPO', 'POController@cancelPO');
 		Route::post('/addProductToPO', 'POController@addProductToPO');
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
 	#STOCK TRANSFER ROUTES
 		Route::post('/saveST', 'STController@saveSO');
 		Route::post('/viewST', 'STController@viewSO');
 		Route::post('/viewSTDetails', 'STController@viewSODetails');
 		Route::post('/saveEditedST', 'STController@saveEditedSO');

 	#INVENTORY ADJUSTMENT ROUTES
 		Route::post('/saveIA', 'IAController@saveIA');
 		Route::post('/viewIA', 'IAController@viewIA');
 		Route::post('/viewIADetails', 'IAController@viewIADetails');
 		Route::post('/saveEditedIA', 'IAController@saveEditedIA');
	});

#File Maintenance Filters
Route::group(["before" => "admin"], function(){
 	#Product Categories
 		Route::post('/addCategory', 'ProductCategoriesController@addCategory');
 		Route::post('/editCategory', 'ProductCategoriesController@editCategory');
 	#Suppliers
 		Route::post('/Suppliers.store', 'Suppliers@store');
 		Route::post('/fetchSupplier', 'SuppliersController@fetchSupplier');
 	#Products
 		Route::post('/Products.store', 'Products@store');
 		Route::post('/fetchProduct', 'ProductsController@fetchProduct');
 	#Banks
 		Route::resource('/banks', 'BanksController');
 		Route::get('/toEditBank','BanksController@toEditBank');
 		Route::get('delete-bank/{id}', 'BanksController@destroy');
 	#branch library
 		Route::resource('/branches', 'BranchesController');
 		Route::get('/toEditBranch','BranchesController@toEditBranch');
 		Route::get('delete-branch/{id}', 'BranchesController@destroy');
 	#customer library
 		Route::resource('/customers', 'CustomersController');
 		Route::get('/toEditCustomer','CustomersController@toEditCustomer');
 		Route::get('delete-customer/{id}', 'CustomersController@destroy');
 	#user library
 		Route::resource('/Users', 'UsersController');
 	
});

#tester
// Route::get('/tester', function()
// {
// 	$vwtest = VwInventorySource::selectRaw('vwinventorysource.ProductNo, vwinventorysource.ProductName, vwinventorysource.BrandName, 
//     vwinventorysource.RetailUnit As Unit, 
//      LotNo, ExpiryDate, (SellingPrice/RetailQtyPerWholeSaleUnit) As UnitPrice, 
//      Sum(RetailSaleQty) Qty')
//     ->join('products','vwinventorysource.productNo','=','products.id')
//     ->groupBy('vwinventorysource.ProductNo','vwinventorysource.ProductName','vwinventorysource.BrandName',
//       'vwinventorysource.RetailUnit','vwinventorysource.LotNo','vwinventorysource.ExpiryDate','vwinventorysource.SellingPrice',
//       'RetailQtyPerWholeSaleUnit')
//     ->get();

//   dd($vwtest[0]->LotNo);
// });
