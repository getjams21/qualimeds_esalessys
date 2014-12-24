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
		return SalesInvoice::selectRaw('SalesInvoices.*,u.Lastname,u.Firstname,u.MI')->join('Users AS u', 'u.id', '=', 'SalesInvoices.UserNo')
			->leftJoin('PaymentDetails AS b', 'b.SalesInvoiceNo', '=', 'SalesInvoices.id')
			->whereNotIn('SalesInvoices.ApprovedBy', array(''))->where('SalesInvoices.IsCancelled', '=', 0)
			->whereNull('b.SalesInvoiceNo')
			->get();
	}
	public function getAllWithCusAndRep(){
		return SalesInvoice::selectRaw('SalesInvoices.*,pc.CustomerName,u.Lastname,u.Firstname,u.MI')->join('Customers AS pc', 'pc.id', '=', 'SalesInvoices.CustomerNo')
			->join('Users AS u', 'SalesInvoices.UserNo', '=', 'u.id')->get();
	}
}