<?php

class VwReceivableSource extends \Eloquent {
	protected $table = 'vwreceivablesource';
	protected $fillable = [
		'SalesRep',
		'CustomerName'
	];
}