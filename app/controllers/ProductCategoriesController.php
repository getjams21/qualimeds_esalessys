<?php

class ProductCategoriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /productcategories
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = ProductCategory::all();
		return View::make('dashboard.ProductCategories.index',compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /productcategories/create
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}
	public function addCategory()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$cat = $input['cat'];
  			$category = new ProductCategory;
  			$category->ProdCatName = $cat;
  			$category->save();
			return Response::json($category);
  		}
	}


	/**
	 * Store a newly created resource in storage.
	 * POST /productcategories
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /productcategories/{id}
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
	 * GET /productcategories/{id}/edit
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
	 * PUT /productcategories/{id}
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
	 * DELETE /productcategories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}