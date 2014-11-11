<?php
use Acme\Repos\ProductCategory\ProductCategoryRepository;
class ProductCategoriesController extends \BaseController {
	private $productCategoryRepo;

	function __construct(ProductCategoryRepository $productCategoryRepo)
		{
			$this->productCategoryRepo = $productCategoryRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /productcategories
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = $this->productCategoryRepo->getAll();
		return View::make('dashboard.ProductCategories.list',compact('categories'));
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
  			$ProdCatName = $input['ProdCatName'];
  			$find = $this->productCategoryRepo->getCatCount($ProdCatName);
  			if($find != 0){
  				return Response::json(0);	
  			}else{
	  			$category = $this->productCategoryRepo->addNew($input);
				return Response::json($category);
			}
  		}
	}
	
	public function editCategory()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$ProdCatName = $input['ProdCatName'];
  			$id = $input['id'];
  			$find = $this->productCategoryRepo->getCount($ProdCatName,$id);
  			if($find != 0){
  				return Response::json(0);	
  			}else{
  				$category = $this->productCategoryRepo->getById($id);
		  			$category->ProdCatName = $ProdCatName;
		  			$category->save();
				return Response::json($category->ProdCatName);
			}
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