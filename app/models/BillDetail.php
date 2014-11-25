<?php

class BillDetail extends \Eloquent {
	protected $table = 'billdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'ProductNo',
		'Barcode',
		'LotNo',
		'ExpiryDate',
		'FreebiesQty',
		'FreebiesUnit',
		'CostPerQty'
	];
}