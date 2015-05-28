<?php

class CustomerReturnDetail extends \Eloquent {
	protected $table = 'customerreturndetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'CustomerReturnNo',
		'ProductNo',
		'Unit',
		'LotNo',
		'Qty',
		'FreebiesQty',
		'FreebiesUnit',
		'UnitPrice'
		];
}