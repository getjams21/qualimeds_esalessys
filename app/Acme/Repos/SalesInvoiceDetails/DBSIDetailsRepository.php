<?php namespace Acme\Repos\SalesInvoiceDetails;

use Acme\Repos\DbRepository;
use SalesInvoiceDetail;
class DBSIDetailsRepository extends DbRepository implements SIDetailsRepository{
	protected $model;
	public function __construct(SalesInvoiceDetail $model){
		$this->model = $model;
	}
	public function getAllBySO($id){
		return SalesInvoiceDetail::selectRaw('Salesinvoicedetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')
			->join('products AS pc', 'pc.id', '=', 'Salesinvoicedetails.ProductNo')
			->where('Salesinvoicedetails.SalesInvoiceNo', '=', $id)->get();

	}
	// public function getAllBySI($id){
	// 	return SalesInvoiceDetail::selectRaw('Salesinvoicedetails.*,p.ProductName,pc.BrandName')
	// 		->join('products as p','p.id','=','Salesinvoicedetails.ProductNo')
	// 		->where('Salesinvoicedetails.SalesInvoiceNo', '=', $id)
	// 		->get();
	// }
}