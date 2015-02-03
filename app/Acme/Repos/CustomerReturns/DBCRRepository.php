<?php namespace Acme\Repos\CustomerReturns;

use Acme\Repos\DbRepository;
use CustomerReturn;
class DBCRRepository extends DbRepository implements CRRepository{
	protected $model;
	public function __construct(CustomerReturn $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return CustomerReturn::max('id');;
	}
	public function getAllWithBranch(){
		return CustomerReturn::selectRaw('Customerreturns.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Customerreturns.BranchNo')->get();
	}
	public function getByIdWithBranch($id){
		// return CustomerReturn::selectRaw('inventoryadjustments.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Inventoryadjustments.BranchNo')->where('Inventoryadjustments.id', '=', $id)->get();
	}
	// public function getAllApprovedIA(){
	// 	return InventoryAdjustment::selectRaw('Inventoryadjustments.*,pc.BranchName')->join('Branches AS pc', 'pc.id', '=', 'Inventoryadjustment.BranchNo')
	// 	->leftJoin('Bills AS b', 'b.PurchaseOrderNo', '=', 'Purchaseorders.id')
	// 	->whereNotIn('Purchaseorders.ApprovedBy', array(''))->where('Purchaseorders.IsCancelled', '=', 0)
	// 	->whereNull('b.PurchaseOrderNo')
	// 	->get();
	// }
}