<?php

class Customer extends \Eloquent {
	protected $table = 'customers';
	protected $guarded = ['id'];
	protected $fillable = [
		'CustomerName',
		'Address',
		'Telephone1',
		'Telephone2',
		'ContactPerson',
		'CreditLimt'
	];
}