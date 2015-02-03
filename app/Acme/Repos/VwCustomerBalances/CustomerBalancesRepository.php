<?php namespace Acme\Repos\VwCustomerBalances;

interface CustomerBalancesRepository{
	public function getAll();
	public function getByid($id);
	public function getSumByCustomerNo($id);
}