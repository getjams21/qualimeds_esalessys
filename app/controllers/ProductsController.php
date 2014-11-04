<?php
use Acme\Forms\ProductForm;
use Acme\Repos\Product\ProductRepository;
class ProductsController extends \BaseController {
	protected $productForm;
	private $productRepo;
	function __construct(ProductForm $productForm, ProductRepository $productRepo)
		{
			$this->productForm = $productForm;
			$this->productRepo = $productRepo;
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
    	$products= $this->productRepo->getAllWithCat();
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
							'RetailQtyPerWholeSaleUnit','Reorderpoint','Markup1','Markup2','Markup3','ActiveMarkup');
		$id = $input['id'];
		$this->productForm->validate($input);
		if($id != null){
			$supplier =$this->productRepo->getById($id);
			$supplier->fill($input)->save();
		}else{
			$supplier = $this->productRepo->addNew($input);
		}
		return Redirect::to('/Products')->withFlashMessage('<div class="alert alert-success square" role="alert">Successfully Updated Record.</div>');
	}
	public function fetchProduct()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$product = $this->productRepo->getById($id);
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