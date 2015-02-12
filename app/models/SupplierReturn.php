<?php

class SupplierReturn extends \Eloquent {
	protected $table = 'supplierreturns';
	protected $guarded = ['id'];
	protected $fillable = [
		'BillNo',
		'BranchNo',
		'ReturnDate',
		'Remarks',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}