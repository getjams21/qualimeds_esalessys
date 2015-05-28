<?php

class AdvancePayment extends \Eloquent {
	protected $table = 'advancepayments';
	protected $guarded = ['id'];
	protected $fillable = [
		'amount',
		'isCharged'
	];
}