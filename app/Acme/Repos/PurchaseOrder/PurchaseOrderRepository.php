<?php namespace Acme\Repos\PurchaseOrder;

interface PurchaseOrderRepository{
	public function getAll();
	public function getAllApprovedPO();
	public function getByid($id);
	public function getMaxId();
	public function getAllWithSup();
	public function getByIdWithSup($id);
}