<?php

class SalesOrderDetails extends \Eloquent {
	protected $table = 'salesorderdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'Barcode',
		'Unit',
		'LotNo',
		'ExpiryDate',
		'Qty',
		'UnitPrice'
		];
}