<?php

class Supplier extends \Eloquent {
	protected $table = 'suppliers';
	protected $guarded = ['id'];
	protected $fillable = [
		'SupplierName',
		'Address',
		'Telephone1',
		'Telephone2',
		'ContactPerson'
	];
}