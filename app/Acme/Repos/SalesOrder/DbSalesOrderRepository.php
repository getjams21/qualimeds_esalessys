<?php namespace Acme\Repos\SalesOrder;

use Acme\Repos\DbRepository;
use SalesOrder;
class DbSalesOrderRepository extends DbRepository implements SalesOrderRepository{
	protected $model;
	public function __construct(SalesOrder $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return SalesOrder::max('id');;
	}
	public function getAllWithCus(){
		return SalesOrder::selectRaw('Salesorders.*,c.CustomerName')->join('Customers AS c', 'c.id', '=', 'Salesorders.CustomerNo')->get();
	}
	public function getByIdWithCus($id){
		return SalesOrder::selectRaw('Salesorders.*,c.CustomerName')->join('Customers AS c', 'c.id', '=', 'Salesorders.CustomerNo')->where('Salesorders.id', '=', $id)->get();
	}
	public function getByIdWithSalesRep($id){
		return SalesOrder::selectRaw('Salesorders.*, CONCAT(u.Firstname," ",u.Lastname) as name')->join('users AS u', 'u.id', '=', 'Salesorders.UserNo')->where('Salesorders.id', '=', $id)->get();
	}
}