<?php namespace Acme\Repos\InventoryAdjustments;

interface InventoryAdjustmentRepository{
	public function getAll();
	// public function getAllApprovedIA();
	public function getByid($id);
	public function getMaxId();
	// public function getAllWithSup();
	// public function getByIdWithSup($id);
}