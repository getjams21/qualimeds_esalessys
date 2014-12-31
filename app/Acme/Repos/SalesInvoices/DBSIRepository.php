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
		return SalesInvoice::selectRaw('SalesInvoices.*,u.id as medrep,u.Lastname,u.Firstname,u.MI,c.CustomerName')->join('Users AS u', 'u.id', '=', 'SalesInvoices.UserNo')
			->join('Customers AS c', 'c.id', '=', 'SalesInvoices.CustomerNo')
			->leftJoin('PaymentInvoices AS b', 'b.invoiceNo', '=', 'SalesInvoices.id')
			->whereNotIn('SalesInvoices.ApprovedBy', array(''))->where('SalesInvoices.IsCancelled', '=', 0)
			->whereNull('b.invoiceNo')
			->get();
	}
	public function getAllWithCusAndRep(){
		return SalesInvoice::selectRaw('SalesInvoices.*,pc.CustomerName,u.Lastname,u.Firstname,u.MI')->join('Customers AS pc', 'pc.id', '=', 'SalesInvoices.CustomerNo')
			->join('Users AS u', 'SalesInvoices.UserNo', '=', 'u.id')->get();
	}
	public function getByidWithMedRep($id){
		return SalesInvoice::selectRaw('SalesInvoices.*,u.Lastname,u.Firstname,u.MI,c.CustomerName')->join('Users AS u', 'u.id', '=', 'SalesInvoices.UserNo')
		->join('Customers AS c', 'SalesInvoices.CustomerNo', '=', 'c.id')->where('SalesInvoices.id', '=', $id)->get();
	}
}