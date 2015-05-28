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
			->whereNotIn('SalesInvoices.ApprovedBy', array(''))->where('SalesInvoices.IsCancelled', '=', 'N')
			->whereNull('b.invoiceNo')
			->get();
	}
	public function getAllWithCusAndRep(){
		return SalesInvoice::selectRaw('SalesInvoices.*,pc.CustomerName,u.Lastname,u.Firstname,u.MI,s.invoiceNo as paid')->join('Customers AS pc', 'pc.id', '=', 'SalesInvoices.CustomerNo')
			->join('Users AS u', 'SalesInvoices.UserNo', '=', 'u.id')
			->leftJoin('PaymentInvoices AS s', 's.invoiceNo', '=', 'SalesInvoices.id')
			->get();
	}
	public function getByidWithMedRep($id){
		return SalesInvoice::selectRaw('SalesInvoices.*,u.Lastname,u.Firstname,u.MI,c.CustomerName')->join('Users AS u', 'u.id', '=', 'SalesInvoices.UserNo')
		->join('Customers AS c', 'SalesInvoices.CustomerNo', '=', 'c.id')->where('SalesInvoices.id', '=', $id)->get();
	}
	public function getAllByCustomer($id){
		return SalesInvoice::selectRaw('SalesInvoices.*')
			->join('customers as c', 'SalesInvoices.CustomerNo', '=', 'c.id')
			->where('c.id','=',$id)
			->whereNotExists(function($query)
	            {
	                $query->selectRaw('invoiceNo')
	                      ->from('paymentinvoices')
	                      ->whereRaw('SalesInvoices.id = paymentinvoices.invoiceNo');
	            })
			->get();
	}
	public function getAllByCustomerWithProduct($customerNo,$productNo){
		return SalesInvoice::selectRaw('salesinvoices.id,salesinvoices.created_at as date,sid.UnitPrice,p.ProductName')
			->join('salesinvoicedetails as sid','sid.SalesInvoiceNo','=','salesinvoices.id')
			->join('products as p','p.id','=','sid.ProductNo')
			->where('sid.ProductNo','=',$productNo)
			->where('salesinvoices.CustomerNo','=',$customerNo)
			->orderBy('salesinvoices.created_at','desc')
			->get();	
	}
}