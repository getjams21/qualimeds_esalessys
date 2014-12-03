<?php

class BillPaymentDetail extends \Eloquent {
	protected $table = 'billpaymentdetails';
	protected $guarded = ['id'];
	protected $fillable = [
	'BillNo',
	'amount'
	];
}