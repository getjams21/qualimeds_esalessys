<?php

class SupplierReturnDetails extends \Eloquent {
	protected $table = 'supplierreturndetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'SupplierReturnNo',
		'ProductNo',
		'Unit',
		'LotNo',
		'Qty',
		'FreebiesQty',
		'FreebiesUnit',
		'UnitPrice'
		];
}