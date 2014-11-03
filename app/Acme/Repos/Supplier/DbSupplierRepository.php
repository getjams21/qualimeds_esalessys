<?php namespace Acme\Repos\Supplier;

use Acme\Repos\DbRepository;
use Supplier;
class DbSupplierRepository extends DbRepository implements SupplierRepository{
	protected $model;
	public function __construct(Supplier $model){
		$this->model = $model;
	}
}