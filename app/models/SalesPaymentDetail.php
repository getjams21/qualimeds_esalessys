<?php

class SalesPaymentDetail extends \Eloquent {
	protected $table = 'paymentdetails';
	protected $guarded = ['id'];
	protected $fillable = [
		'PaymentNo',
		'SalesInvoiceNo',
		'PaymentType',
		'CheckNo',
		'CheckDueDate',
		'amount',
		'BankNo',
		'IsCheckEncash'
	];
}