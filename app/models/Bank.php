<?php

class Bank extends \Eloquent {
	protected $table = 'banks';
	protected $guarded = ['id'];
	protected $fillable = [
		'BankName',
		'BAddress',
		'Telephone'
	];
}