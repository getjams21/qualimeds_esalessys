<?php namespace Acme\Repos\PurchaseOrder;

use Acme\Repos\DbRepository;
use PurchaseOrder;
class DbPurchaseOrderRepository extends DbRepository implements PurchaseOrderRepository{
	protected $model;
	public function __construct(PurchaseOrder $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return PurchaseOrder::max('id');
	}
	public function getAllWithSup(){
		return PurchaseOrder::selectRaw('Purchaseorders.*,pc.SupplierName,b.PurchaseOrderNo as billed')->join('Suppliers AS pc', 'pc.id', '=', 'Purchaseorders.SupplierNo')
			->leftJoin('Bills AS b', 'b.PurchaseOrderNo', '=', 'Purchaseorders.id')
			->get();
	}
	public function getByIdWithSup($id){
		return PurchaseOrder::selectRaw('Purchaseorders.*,b.BranchName,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Purchaseorders.SupplierNo')
		->join('Branches AS b', 'Purchaseorders.BranchNo', '=', 'b.id')->where('Purchaseorders.id', '=', $id)->get();
	}
	public function getAllApprovedPO(){
		return PurchaseOrder::selectRaw('Purchaseorders.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Purchaseorders.SupplierNo')
		->leftJoin('Bills AS b', 'b.PurchaseOrderNo', '=', 'Purchaseorders.id')
		->whereNotIn('Purchaseorders.ApprovedBy', array(''))->where('Purchaseorders.IsCancelled', '=', 'N')
		->whereNull('b.PurchaseOrderNo')
		->get();
	}
}