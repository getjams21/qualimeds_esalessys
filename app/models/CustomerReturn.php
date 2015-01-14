<?php

class CustomerReturn extends \Eloquent {
	protected $table = 'customerreturns';
	protected $guarded = ['id'];
	protected $fillable = [
		'SalesinvoiceNo',
		'BranchNo',
		'CustomerReturnDate',
		'Remarks',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}