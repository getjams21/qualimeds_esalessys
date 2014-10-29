<?php

class CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Customers = Customer::all();
		return View::make('dashboard.customers.customers', compact('Customers'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$customer = new Customer;
		$customer->CustomerName = Input::get('name');
		$customer->Address	= Input::get('address');
		$customer->Telephone1 = Input::get('telephone1');
		$customer->Telephone2 = Input::get('telephone2');
		$customer->ContactPerson = Input::get('contact-person');
		$customer->CreditLimit = Input::get('credit-limit');
		$customer->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Customer is Successfully added.
					</div>
				');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = Customer::find($id);
		$customer->CustomerName = Input::get('name');
		$customer->Address	= Input::get('address');
		$customer->Telephone1 = Input::get('telephone1');
		$customer->Telephone2 = Input::get('telephone2');
		$customer->ContactPerson = Input::get('contact-person');
		$customer->CreditLimit = Input::get('credit-limit');
		$customer->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Customer is Successfully updated.
					</div>
				');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$customer = Customer::find($id);
		$customer->delete();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Customer is Successfully deleted.
					</div>
				');
	}
	public function toEditCustomer(){
		if(Request::ajax()){
  			$customer = DB::select('select * from customers where id = '.Input::get('id').'');
			return Response::json($customer);
  		}
	}


}
