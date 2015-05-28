<?php namespace Acme\Repos\BillPayments;

use Acme\Repos\DbRepository;
use BillPayment;
class DbBillPaymentsRepository extends DbRepository implements BillPaymentsRepository{
	protected $model;
	public function __construct(BillPayment $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return BillPayment::max('id');
	}
	public function getMaxCashVoucher(){
		return BillPayment::max('CashVoucherNo');
	}
	public function getMaxCheckVoucher(){
		return BillPayment::max('CheckVoucherNo');
	}
}