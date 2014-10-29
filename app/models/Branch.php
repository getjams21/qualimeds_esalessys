<?php

class Branch extends \Eloquent {
	protected $table = 'branches';
	protected $guarded = ['id'];
	protected $fillable = [
		'BranchName',
		'BAddress',
		'Telephone'
	];
}