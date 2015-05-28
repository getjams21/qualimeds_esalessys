<?php namespace Acme\Repos\SalesOrder;

interface SalesOrderRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getAllWithCus();
	public function getByIdWithCus($id);
	public function getAllApprovedSO();
}