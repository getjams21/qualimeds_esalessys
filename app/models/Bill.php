<?php

class Bill extends \Eloquent {
	protected $table = 'bills';
	protected $guarded = ['id'];
	protected $fillable = [
		'SalesInvoiceNo',
		'SalesInvoiceDate',
		'Terms',
		'PreparedBy',
		'ApprovedBy',
		'CancelledBy'
	];
}