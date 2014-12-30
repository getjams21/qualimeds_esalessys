<?php namespace Acme\Repos\SalesPayment;

use Acme\Repos\DbRepository;
use SalesPayment;
class DbSalesPaymentRepository extends DbRepository implements SalesPaymentRepository{
	protected $model;
	public function __construct(SalesPayment $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return SalesPayment::max('id');
	}
}