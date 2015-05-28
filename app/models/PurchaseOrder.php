<?php

class PurchaseOrder extends \Eloquent {
	protected $table = 'purchaseorders';
	protected $guarded = ['id'];
	protected $fillable = [
		'PODate',
		'Terms',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}