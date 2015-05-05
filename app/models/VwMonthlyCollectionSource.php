<?php

class VwMonthlyCollectionSource extends \Eloquent {
	protected $table = 'vwmonthlycollectionsource';
	protected $guarded = ['id'];
	protected $fillable = [
		'SalesRep',
		'ORnumber',
		'CustomerName',
		'PaymentDate',
		'CheckNo',
		'CheckDueDate',
		'Amount'
		];
}