<?php namespace Acme\Repos\BillPaymentDetails;

use Acme\Repos\DbRepository;
use BillPaymentDetail;
class DbBillPaymentDetailsRepository extends DbRepository implements BillPaymentDetailsRepository{
	protected $model;
	public function __construct(BillPaymentDetail $model){
		$this->model = $model;
	}
  	public function getAllWithSup($id){
  		return BillPaymentDetail::selectRaw('BillPaymentDetails.*,a.SalesInvoiceNo as InvoiceNo,pc.id as SupplierNo,pc.SupplierName')
  			->join('Bills AS a', 'a.id', '=', 'BillPaymentDetails.BillNo')
  			->join('Suppliers AS pc', 'pc.id', '=', 'a.SupplierNo')
  			->where('BillPaymentDetails.BillPaymentNo', '=', $id)->get();
  	}
    public function getByBP($id){
      return BillPaymentDetail::where('BillPaymentNo','=',$id)->get();
    }
}