<?php

class SalesPaymentDetail extends \Eloquent {
	protected $table = 'paymentdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'SalesInvoiceNo',
		'PaymentType',
		'CheckNo',
		'CheckDueDate',
		'amount',
		'BankNo',
		'IsCheckEncash'
	];
}