<?php

class BranchesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Branches = Branch::all();
		return View::make('dashboard.branches.branches', compact('Branches'));
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
		$branch = new Branch;
		$branch->BranchName = Input::get('name');
		$branch->BAddress	= Input::get('address');
		$branch->Telephone = Input::get('telephone');
		$branch->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Branch is Successfully added.
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
		$branch = Branch::find($id);
		$branch->BranchName = Input::get('name');
		$branch->BAddress	= Input::get('address');
		$branch->Telephone = Input::get('telephone');
		$branch->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Branch is Successfully updated.
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
		$branch = Branch::find($id);
		$branch->delete();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						Branch is Successfully deleted.
					</div>
				');
	}

	public function toEditBranch(){
		if(Request::ajax()){
  			$branch = DB::select('select * from branches where id = '.Input::get('id').'');
			return Response::json($branch);
  		}
	}


}
