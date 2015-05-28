<?php

class StockTransfer extends \Eloquent {
	protected $table = 'stocktransfers';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchSourceNo',
		'BranchDestinationNo',
		'TransferDate',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}