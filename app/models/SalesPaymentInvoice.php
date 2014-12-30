<?php

class SalesPaymentInvoice extends \Eloquent {
	protected $table = 'paymentinvoices';
	protected $guarded = ['id'];
	protected $fillable = [
		'invoiceNo',
		'paymentNo',
		'amount'
	];
}