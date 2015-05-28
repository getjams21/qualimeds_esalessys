<?php

class VwMonthlySalesSource extends \Eloquent {
	protected $table = 'vwmonthlysalessource';
	protected $guarded = ['id'];
	protected $fillable = [
		'Trans',
		'SalesRep',
		'TransDate',
		'CustomerName',
		'SalesInvoiceRefDocNo',
		'Remarks',
		'Amount'
		];
}