<?php

class ProductCategory extends \Eloquent {
	protected $table = 'productcategories';
	protected $guarded = ['id'];
	protected $fillable = [
		'ProdCatName'
	];
}