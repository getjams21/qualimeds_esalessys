<?php namespace Acme\Repos\InventoryAdjustments;

use Acme\Repos\DbRepository;
use InventoryAdjustment;
class DbInventoryAdjustmentRepository extends DbRepository implements InventoryAdjustmentRepository{
	protected $model;
	public function __construct(InventoryAdjustment $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return InventoryAdjustment::max('id');;
	}
	public function getAllWithBranch(){
		return InventoryAdjustment::selectRaw('Inventoryadjustments.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Inventoryadjustments.BranchNo')->get();
	}
	public function getByIdWithBranch($id){
		return InventoryAdjustment::selectRaw('Inventoryadjustments.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Inventoryadjustments.BranchNo')->where('Inventoryadjustments.id', '=', $id)->get();
	}
	public function getAllApprovedIA(){
		return InventoryAdjustment::selectRaw('Inventoryadjustments.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Inventoryadjustment.SupplierNo')
		->leftJoin('Bills AS b', 'b.PurchaseOrderNo', '=', 'Purchaseorders.id')
		->whereNotIn('Purchaseorders.ApprovedBy', array(''))->where('Purchaseorders.IsCancelled', '=', 0)
		->whereNull('b.PurchaseOrderNo')
		->get();
	}
}