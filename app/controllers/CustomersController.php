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
		$input = Input::only('id','CustomerName','Address','Telephone1','Telephone2','ContactPerson','CreditLimit');
		if($input['id'] == ''){
			$customer = Customer::create($input);
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Customer is Successfully added.
						</div>
					');
		}else{
			// dd($input['id']);
			$customer = Customer::find($input['id']);
			$customer->fill($input)->save();
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Customer is Successfully updated.
						</div>
					');
		}
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
		//
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
  			$customer = Customer::find(Input::get('id'));
			return Response::json($customer);
  		}
	}


}
