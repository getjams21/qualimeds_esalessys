<?php

class CreditMemo extends \Eloquent {
	protected $table = 'creditmemo';
	protected $guarded = ['id'];
	protected $fillable = [
		'customerno',
		'creditmemodate',
		'amount',
		'branchno',
		'userno'
	];
}