<?php namespace Acme\Repos\PurchaseOrder;

use Acme\Repos\DbRepository;
use PurchaseOrder;
class DbPurchaseOrderRepository extends DbRepository implements PurchaseOrderRepository{
	protected $model;
	public function __construct(PurchaseOrder $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return PurchaseOrder::max('id');;
	}
	public function getAllWithSup(){
		return PurchaseOrder::selectRaw('Purchaseorders.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Purchaseorders.SupplierNo')->get();
	}
	public function getByIdWithSup($id){
		return PurchaseOrder::selectRaw('Purchaseorders.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Purchaseorders.SupplierNo')->where('Purchaseorders.id', '=', $id)->get();
	}
}