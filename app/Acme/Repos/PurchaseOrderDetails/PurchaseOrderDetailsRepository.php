<?php namespace Acme\Repos\PurchaseOrderDetails;

interface PurchaseOrderDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllByPO($id);
}