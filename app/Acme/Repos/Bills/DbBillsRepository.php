<?php namespace Acme\Repos\Bills;

use Acme\Repos\DbRepository;
use Bill;
class DbBillsRepository extends DbRepository implements BillsRepository{
	protected $model;
	public function __construct(Bill $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return Bill::max('id');
	}
	public function getByIdWithSup($id){
		return Bill::selectRaw('Bills.*,b.BranchName,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Bills.SupplierNo')
		->join('Branches AS b', 'Bills.BranchNo', '=', 'b.id')->where('Bills.id', '=', $id)->get();
	}
	public function getAllWithSup(){
		return Bill::selectRaw('Bills.*,b.BranchName,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Bills.SupplierNo')
			->join('Branches AS b', 'Bills.BranchNo', '=', 'b.id')->get();
	}
	public function getAllWithSupUnpaid(){
		return Bill::selectRaw('Bills.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Bills.SupplierNo')
			->leftJoin('BillPaymentDetails AS b', 'b.BillNo', '=', 'Bills.id')
			->whereNotIn('Bills.ApprovedBy', array(''))->where('Bills.IsCancelled', '=', 'N')
			->whereNull('b.BillNo')
			->get();
	}
	public function getAllBySupplier($id){
		return Bill::selectRaw('Bills.*')
			->join('suppliers as s', 'Bills.SupplierNo', '=', 's.id')
			->where('s.id','=',$id)
			->whereNotExists(function($query)
	            {
	                $query->selectRaw('BillPaymentNo')
	                      ->from('billpaymentdetails')
	                      ->whereRaw('Bills.id = billpaymentdetails.BillNo');
	            })
			->get();
	}
}