<?php

class DamagesDetails extends \Eloquent {
	protected $table = 'inventorydamagedetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'InvDamagesNo',
		'ProductNo',
		'Unit',
		'LotNo',
		'ExpiryDate',
		'Qty',
		'CostPerQty'
		];
}