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
 	#PURCHASE ORDER ROUTES
 		Route::resource('/PurchaseOrders', 'POController');

});