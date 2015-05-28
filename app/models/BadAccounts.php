<?php

class BadAccounts extends \Eloquent {
	protected $table = 'vwagingofcustomeraccounts';
	protected $fillable = [
		'SalesInvoiceRefDoc',
		'CustomerNo'
		];
}