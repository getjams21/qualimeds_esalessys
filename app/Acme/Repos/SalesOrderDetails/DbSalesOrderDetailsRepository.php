<?php namespace Acme\Repos\SalesOrderDetails;

use Acme\Repos\DbRepository;
use SalesOrderDetails;
class DbSalesOrderDetailsRepository extends DbRepository implements SalesOrderDetailsRepository{
	protected $model;
	public function __construct(SalesOrderDetails $model){
		$this->model = $model;
	}
	public function getAllBySO($id){
		return SalesOrderDetails::selectRaw('Salesorderdetails.*,pc.ProductName,pc.BrandName')
			->join('products AS pc', 'pc.id', '=', 'Salesorderdetails.ProductNo')
			->where('Salesorderdetails.SalesOrderNo', '=', $id)->get();
	}
}
