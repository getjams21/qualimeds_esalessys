<?php namespace Acme\Repos\CustomerReturnDetails;

use Acme\Repos\DbRepository;
use CustomerReturnDetail;
class DBCRDRepository extends DbRepository implements CRDRepository{
	protected $model;
	public function __construct(CustomerReturnDetail $model){
		$this->model = $model;
	}
	public function getAllByIA($id){
		return CustomerReturnDetail::selectRaw('Inventoryadjustmentdetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'Inventoryadjustmentdetails.ProductNo')
		->where('Inventoryadjustmentdetails.InvAdjustmentNo', '=', $id)->get();
	}
}