<?php

class Damage extends \Eloquent {
	protected $table = 'inventorydamages';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchNo',
		'InvDamageDate',
		'Remarks',
		'PreparedBy',
		'ApprovedBy',
		'IsCancelled',
		'CancelledBy'
		];
}