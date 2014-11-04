<?php namespace Acme\Repos\Product;

use Acme\Repos\DbRepository;
use Product;
class DbProductRepository extends DbRepository implements ProductRepository{
	protected $model;
	public function __construct(Product $model){
		$this->model = $model;
	}
	public function getAllWithCat(){
		return Product::selectRaw('Products.*,pc.ProdCatName')->join('ProductCategories AS pc', 'pc.id', '=', 'Products.ProductCatNo')->get();
	}
}