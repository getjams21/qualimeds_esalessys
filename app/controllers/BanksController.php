<?php

class BanksController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bank = new Bank;
		$Banks = Bank::all();
		return View::make('dashboard.banks.index', compact('bank','Banks'));
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
		$input = Input::only('id','BankName','BAddress','Telephone');
		if($input['id'] == ''){
			$customer = Bank::create($input);
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Bank is Successfully added.
						</div>
					');
		}else{
			$customer = Bank::find($input['id']);
			$customer->fill($input)->save();
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Bank is Successfully updated.
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
		echo 'foo';
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bank = Bank::find($id);
		$bank->BankName = Input::get('name');
		$bank->BAddress	= Input::get('address');
		$bank->Telephone = Input::get('telephone');
		$bank->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Bank is Successfully updated.
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
	public function destroy($code,$id)
	{
		$bank = Bank::find($id);
		$bank->IsActive = 0;
		$bank->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Bank is Successfully deactivated.
					</div>
				');
	}

	public function toEditBank(){
		if(Request::ajax()){
  			$bank = Bank::find(Input::get('id'));
			return Response::json($bank);
  		}
	}

}
