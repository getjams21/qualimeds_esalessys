<?php

class PurchaseOrderDetails extends \Eloquent {
	protected $table = 'purchaseorderdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'Unit',
		'Qty',
		'CostPerQty'
		];
}