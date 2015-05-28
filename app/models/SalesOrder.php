<?php

class SalesOrder extends \Eloquent {
	protected $table = 'salesorders';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchNo',
		'SalesOrderDate',
		'CustomerNo',
		'UserNo',
		'Terms',
		'IsCancelled',
		'CancelledBy'
		];
}