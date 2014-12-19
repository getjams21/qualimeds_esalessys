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

Route::group(["before" => "auth"], function() {
	Route::get('/', 'PagesController@home');
	#File Maintenance Filters
	Route::group(["before" => "admin"], function(){
		Route::resource('/ProductCategories', 'ProductCategoriesController');
	 	#new product category ajax post
	 		Route::post('/addCategory', 'ProductCategoriesController@addCategory');
	 		Route::post('/editCategory', 'ProductCategoriesController@editCategory');
	 	Route::resource('/Suppliers', 'SuppliersController');
	 		Route::post('/fetchSupplier', 'SuppliersController@fetchSupplier');
	 	Route::resource('/Products', 'ProductsController');
	 		Route::post('/fetchProduct', 'ProductsController@fetchProduct');
	 	#banks library
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
	 		Route::get('/toEditUser','UsersController@toEditUser');
	 		Route::get('delete-user/{id}', 'UsersController@destroy');
	 		Route::get('/verifyCurrentPassword', 'UsersController@validateCurrentPassword');
 		});
	#Update Account
		Route::get('update-account', 'UsersController@editAccount');
	#Transactions
 	#PURCHASE ORDER ROUTES
 		Route::resource('/PurchaseOrders', 'POController');
	 		Route::post('/savePO', 'POController@savePO');
	 		Route::post('/viewPO', 'POController@viewPO');
	 		Route::post('/viewPODetails', 'POController@viewPODetails');
	 		Route::post('/saveEditedPO', 'POController@saveEditedPO');
	 		Route::post('/approvePO', 'POController@approvePO');
	 		Route::post('/cancelPO', 'POController@cancelPO');
	 		Route::get('/productDtAjax', array('as' => 'productDtAjax', 'uses' => 'POController@productDtAjax')); 
	 		Route::post('/addProductToPO', 'POController@addProductToPO');
	 #BILLS ROUTES
	 	Route::resource('/Bills', 'BillsController');
	 	Route::post('/savePOBill', 'BillsController@savePOBill');
	 	Route::post('/viewBill', 'BillsController@viewBill');
	 	Route::post('/viewBillDetails', 'BillsController@viewBillDetails');
	 	Route::post('/saveEditedPOBill', 'BillsController@saveEditedPOBill');
	 	Route::post('/cancelBill', 'BillsController@cancelBill');
		Route::post('/approveBill', 'BillsController@approveBill');
		
 	#SALES ORDER ROUTES
 		Route::resource('/SalesOrders', 'SOController');
 		Route::post('/saveSO', 'SOController@saveSO');
 		Route::post('/viewSO', 'SOController@viewSO');
 		Route::post('/viewSODetails', 'SOController@viewSODetails');
 		Route::post('/saveEditedSO', 'SOController@saveEditedSO');
 		Route::get('/changeSOType', 'SOController@changeSOType');
 	#BILLPAYMENTS ROUTES
 		Route::resource('/BillPayments', 'BillPaymentsController');
 		Route::post('/addBillToPayment', 'BillPaymentsController@addBillToPayment');
 		Route::post('/billPayment', 'BillPaymentsController@billPayment');
 		Route::post('/getbillPayments', 'BillPaymentsController@getbillPayments');
 		Route::post('/getbillPaymentDetails', 'BillPaymentsController@getbillPaymentDetails');

 		Route::get('/changeSOType', 'SOController@changeSOType');
 	#SALES INVOICE ROUTES
 		Route::resource('/SalesInvoice', 'SalesInvoiceController');
 		Route::post('/viewSO', 'SalesInvoiceController@viewSO');
 		Route::post('/viewSODetails', 'SalesInvoiceController@viewSODetails');
 		Route::post('/saveSOBill', 'SalesInvoiceController@saveSOBill');
 		Route::post('/viewSI', 'SalesInvoiceController@viewSI');
 		Route::post('/viewSIDetails', 'SalesInvoiceController@viewSIDetails');
 		Route::post('/saveEditedSI', 'SalesInvoiceController@saveEditedSI');
 		Route::post('/approveSI', 'SalesInvoiceController@approveSI');
 		Route::post('/cancelSI', 'SalesInvoiceController@cancelSI');

 	#STOCK TRANSFER ROUTES
 		Route::resource('/stocks-transfer', 'STController');
 		Route::post('/saveST', 'STController@saveSO');
 		Route::post('/viewST', 'STController@viewSO');
 		Route::post('/viewSTDetails', 'STController@viewSODetails');
 		Route::post('/saveEditedST', 'STController@saveEditedSO');

 	#INVENTORY ADJUSTMENT ROUTES
 		Route::resource('/inventory-adjustment', 'IAController');
 		Route::post('/saveIA', 'IAController@saveIA');
 		Route::post('/viewIA', 'IAController@viewIA');
 		Route::post('/viewIADetails', 'IAController@viewIADetails');
 		Route::post('/saveEditedIA', 'IAController@saveEditedIA');
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
