<?php

class CustomerLedger extends \Eloquent {
	protected $table = 'vwcustomerledger';
	protected $guarded = ['id'];
	protected $fillable = [
		'trantype',
		'sourcedoc',
		'trandate',
		'amount'
		];
}