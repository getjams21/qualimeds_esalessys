<?php

class BillPayment extends \Eloquent {
	protected $table = 'billpayments';
	protected $guarded = ['id'];
	protected $fillable = [
		'PaymentDate',
		'PaymentType',
		'CashVoucherNo',
		'CheckVoucherNo',
		'CheckNo',
		'Amount',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
	];
}