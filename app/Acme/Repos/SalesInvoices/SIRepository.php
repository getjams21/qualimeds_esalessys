<?php namespace Acme\Repos\SalesInvoices;

interface SIRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getAllWithUnpaid();
	public function getAllWithCusAndRep();
	public function getByidWithMedRep($id);
	public function getAllByCustomer($id);
	public function getAllByCustomerWithProduct($customerNo,$productNo);
}