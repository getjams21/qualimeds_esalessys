<?php namespace Acme\Repos\BillPayments;

interface BillPaymentsRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getMaxCashVoucher();
}