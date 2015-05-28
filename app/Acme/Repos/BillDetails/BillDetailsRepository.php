<?php namespace Acme\Repos\BillDetails;

interface BillDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllByBill($id);
}