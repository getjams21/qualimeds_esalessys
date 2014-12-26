<?php

class InventoryAdjustment extends \Eloquent {
	protected $table = 'inventoryadjustments';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchNo',
		'AdjustmentDate',
		'Remarks',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}