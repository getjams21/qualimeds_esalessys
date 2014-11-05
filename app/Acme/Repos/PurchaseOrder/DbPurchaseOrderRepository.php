<?php namespace Acme\Repos\PurchaseOrder;

use Acme\Repos\DbRepository;
use PurchaseOrder;
class DbPurchaseOrderRepository extends DbRepository implements PurchaseOrderRepository{
	protected $model;
	public function __construct(PurchaseOrder $model){
		$this->model = $model;
	}
}