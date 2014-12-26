<?php namespace Acme\Repos\InventoryAdjustmentDetails;

interface InventoryAdjustmentDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllByIA($id);
}