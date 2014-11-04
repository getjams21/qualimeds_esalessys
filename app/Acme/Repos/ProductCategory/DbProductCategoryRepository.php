<?php namespace Acme\Repos\ProductCategory;

use Acme\Repos\DbRepository;
use ProductCategory;
class DbProductCategoryRepository extends DbRepository implements ProductCategoryRepository{
	protected $model;
	public function __construct(ProductCategory $model){
		$this->model = $model;
	}
	public function getCount($cat,$id){
		return ProductCategory::where('ProdCatName', '=', $cat)
  									->where('id', '!=', $id)->count();
	}
	public function getCatCount($cat){
		return ProductCategory::where('ProdCatName', '=', $cat)->count();
	}
}