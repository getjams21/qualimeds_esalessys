<?php namespace Acme\Repos\SalesOrderDetails;

interface SalesOrderDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllBySO($id);
}