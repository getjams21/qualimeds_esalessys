<?php namespace Acme\Repos\BillPaymentDetails;

interface BillPaymentDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllWithSup($id);
	public function getByBP($id);
}