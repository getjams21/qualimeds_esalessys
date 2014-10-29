<?php

class Product extends \Eloquent {
	protected $table = 'products';
	protected $guarded = ['id'];
	protected $fillable = [
		'ProductCatNo',
		'ProductName',
		'BrandName',
		'WholeSaleUnit',
		'RetailUnit',
		'RetailQtyPerWholeSaleUnit',
		'Markup1',
		'Markup2',
		'Markup3',
		'ActiveMarkup'
	];
}