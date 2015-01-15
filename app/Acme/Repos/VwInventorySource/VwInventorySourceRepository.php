<?php namespace Acme\Repos\VwInventorySource;

interface VwInventorySourceRepository{
	public function getInventorySourceWholeSale($branchNo);
	public function getInventorySourceRetail();
}