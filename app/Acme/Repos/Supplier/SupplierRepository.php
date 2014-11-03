<?php namespace Acme\Repos\Supplier;

interface SupplierRepository{
	public function getAll();
	public function getByid($id);
}