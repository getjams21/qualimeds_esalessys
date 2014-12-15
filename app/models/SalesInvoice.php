<?php

class SalesInvoice extends \Eloquent {
	protected $table = 'salesinvoices';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchNo',
		'SalesInvoiceRefDocNo',
		'SalesOrderNo',
		'InvoiceDate',
		'CustomerNo',
		'UserNo',
		'Terms',
		'IsCancelled',
		'ApprovedBy',
		'CancelledBy'
	];
}