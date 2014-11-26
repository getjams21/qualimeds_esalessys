<?php namespace Acme\Repos\VwInventorySource;

interface VwInventorySourceRepository{
	public function getInventorySourceWholeSale();
	public function getInventorySourceRetail();
}