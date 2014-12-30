<?php

class SalesPayment extends \Eloquent {
	protected $table = 'payments';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchNo',
		'ORnumber',
		'PaymentDate',
		'UserNo',
		'EncodedBy',
		'IsCancelled',
		'PreparedBy',
		'ApprovedBy',
		'CancelledBy'
	];
}