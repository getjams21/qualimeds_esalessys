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
		return InventoryAdjustment::selectRaw('inventoryadjustments.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'inventoryadjustments.BranchNo')->get();
	}
	public function getByIdWithBranch($id){
		return InventoryAdjustment::selectRaw('inventoryadjustments.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Inventoryadjustments.BranchNo')->where('Inventoryadjustments.id', '=', $id)->get();
	}
	// public function getAllApprovedIA(){
	// 	return InventoryAdjustment::selectRaw('Inventoryadjustments.*,pc.BranchName')->join('Branches AS pc', 'pc.id', '=', 'Inventoryadjustment.BranchNo')
	// 	->leftJoin('Bills AS b', 'b.PurchaseOrderNo', '=', 'Purchaseorders.id')
	// 	->whereNotIn('Purchaseorders.ApprovedBy', array(''))->where('Purchaseorders.IsCancelled', '=', 0)
	// 	->whereNull('b.PurchaseOrderNo')
	// 	->get();
	// }
}