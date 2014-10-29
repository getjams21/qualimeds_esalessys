<?php
use Acme\Forms\ProductForm;
class ProductsController extends \BaseController {
	protected $productForm;
	function __construct(ProductForm $productForm)
		{
			$this->productForm = $productForm;
		}
	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response 
	 */
	public function index()
	{
		$category = ProductCategory::lists('ProdCatName','id');
    	$products=DB::select('Select a.*,b.ProdCatName from products as a inner join productcategories as b on a.ProductCatNo=b.id');
		return View::make('dashboard.Products.list',compact('products','category'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /products
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('id','ProductCatNo','ProductName','BrandName','WholeSaleUnit','RetailUnit',
							'RetailQtyPerWholeSaleUnit','Markup1','Markup2','Markup3','ActiveMarkup');
		$id = $input['id'];
		$this->productForm->validate($input);
		if($id != null){
			$supplier = Product::find($id);
			$supplier->fill($input)->save();
		}else{
			$supplier = Product::create($input);
		}
		return Redirect::to('/Products')->withFlashMessage('<div class="alert alert-success square" role="alert">Successfully Updated Record.</div>');
	}
	public function fetchProduct()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$product = Product::find($id);
		return Response::json($product);
  		}

	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
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
	 * GET /products/{id}/edit
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
	 * PUT /products/{id}
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
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}