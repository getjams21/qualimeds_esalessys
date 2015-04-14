<?php namespace Acme\Repos\CreditMemo;

use Acme\Repos\DbRepository;
use CreditMemo;
class DbCreditMemoRepository extends DbRepository implements CreditMemoRepository{
	protected $model;
	public function __construct(CreditMemo $model){
		$this->model = $model;
	}
	public function getAllWithCat(){
		return CreditMemo::selectRaw('Products.*,pc.ProdCatName')->join('ProductCategories AS pc', 'pc.id', '=', 'Products.ProductCatNo')->get();
	}
}