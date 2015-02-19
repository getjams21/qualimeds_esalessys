<?php namespace Acme\Repos\SupplierReturns;

use Acme\Repos\DbRepository;
use SupplierReturn;
class DBSRRepository extends DbRepository implements SRRepository{
	protected $model;
	public function __construct(SupplierReturn $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return SupplierReturn::max('id');;
	}
	public function getAllWithBranch(){
		return SupplierReturn::selectRaw('SupplierReturns.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'SupplierReturns.BranchNo')->get();
	}
	public function getByIdWithBranch($id){
		return SupplierReturn::selectRaw('SupplierReturns.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'SupplierReturns.BranchNo')->where('SupplierReturns.id', '=', $id)->get();
	}
}