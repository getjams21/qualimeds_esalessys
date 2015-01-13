<?php

class StockTransferDetails extends \Eloquent {
	protected $table = 'stocktransferdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'StockTransferNo',
		'ProductNo',
		'Unit',
		'LotNo',
		'ExpiryDate',
		'Qty',
		'CostPerUnit'
		];
}