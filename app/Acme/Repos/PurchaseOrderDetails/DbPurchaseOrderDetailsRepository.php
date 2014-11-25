<?php namespace Acme\Repos\PurchaseOrderDetails;

use Acme\Repos\DbRepository;
use PurchaseOrderDetails;
class DbPurchaseOrderDetailsRepository extends DbRepository implements PurchaseOrderDetailsRepository{
	protected $model;
	public function __construct(PurchaseOrderDetails $model){
		$this->model = $model;
	}
	public function getAllByPO($id){
		return PurchaseOrderDetails::selectRaw('Purchaseorderdetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'Purchaseorderdetails.ProductNo')
		->where('Purchaseorderdetails.PurchaseOrderNo', '=', $id)->get();

	}
}