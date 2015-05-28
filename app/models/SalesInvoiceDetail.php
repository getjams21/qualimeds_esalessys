<?php

class SalesInvoiceDetail extends \Eloquent {
	protected $table = 'salesinvoicedetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'SalesInvoiceNo',
		'ProductNo',
		'Barcode',
		'Unit',
		'LotNo',
		'ExpiryDate',
		'Qty',
		'UnitPrice',
		'FreebiesQty',
		'FreebiesUnit'
	];
}