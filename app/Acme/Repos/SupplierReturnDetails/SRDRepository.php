<?php namespace Acme\Repos\SupplierReturnDetails;

interface SRDRepository{
	public function getAll();
	public function getByid($id);
	public function getAllBySR($id);
}