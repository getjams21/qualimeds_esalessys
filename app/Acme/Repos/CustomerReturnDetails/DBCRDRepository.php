<?php namespace Acme\Repos\CustomerReturnDetails;

use Acme\Repos\DbRepository;
use CustomerReturnDetail;
class DBCRDRepository extends DbRepository implements CRDRepository{
	protected $model;
	public function __construct(CustomerReturnDetail $model){
		$this->model = $model;
	}
	public function getAllByCR($id){
		return CustomerReturnDetail::selectRaw('Customerreturndetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'Customerreturndetails.ProductNo')
		->where('Customerreturndetails.CustomerReturnNo', '=', $id)->get();
	}
}