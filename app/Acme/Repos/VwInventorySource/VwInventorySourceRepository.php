<?php namespace Acme\Repos\VwInventorySource;

interface VwInventorySourceRepository{
	public function getInventorySourceWholeSale($branchNo);
	public function getInventorySourceRetail();
	public function getInventorySourceForST($branchNo);
	public function productInventorySummary();
	public function productInventoryByLotNo();
	public function productInventoryStockCard();
}