<?php

class InventoryAdjustmentDetails extends \Eloquent {
	protected $table = 'inventoryadjustmentdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'InvAdjustmentNo',
		'ProductNo',
		'Unit',
		'LotNo',
		'ExpiryDate',
		'Qty',
		'CostPerQty'
		];
}