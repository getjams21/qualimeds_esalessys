<?php namespace Acme\Repos\SalesInvoices;

use Acme\Repos\DbRepository;
use SalesInvoice;
class DbSIRepository extends DbRepository implements SIRepository{
	protected $model;
	public function __construct(SalesInvoice $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return SalesInvoice::max('id');
	}
	public function getAllWithUnpaid(){
		return SalesInvoice::selectRaw('SalesInvoice.*,pc.SupplierName')->join('Suppliers AS pc', 'pc.id', '=', 'Bills.SupplierNo')
			->leftJoin('BillPaymentDetails AS b', 'b.BillNo', '=', 'Bills.id')
			->whereNotIn('Bills.ApprovedBy', array(''))->where('Bills.IsCancelled', '=', 0)
			->whereNull('b.BillNo')
			->get();
	}
	public function getAllWithCusAndRep(){
		return SalesInvoice::selectRaw('SalesInvoices.*,pc.CustomerName,u.Lastname,u.Firstname,u.MI')->join('Customers AS pc', 'pc.id', '=', 'SalesInvoices.CustomerNo')
			->join('Users AS u', 'SalesInvoices.UserNo', '=', 'u.id')->get();
	}
}