<?php namespace Acme\Repos\SupplierReturns;

interface SRRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getByIdWithBranch($id);
}