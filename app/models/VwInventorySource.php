<?php

class VwInventorySource extends \Eloquent {
	protected $table = 'vwinventorysource';
	protected $guarded = ['id'];
	protected $fillable = [
		'SourceName',
		'BranchNo',
		'BranchName',
		'TranDate',
		'RefDoc',
		'ProductCatNo',
		'ProdCatName',
		'ProductNo',
		'ProductName',
		'BrandName',
		'ReorderPoint',
		'LotNo',
		'ExpiryDate',
		'CostPerQty',
		'SellingPrice',
		'WholeSaleUnit',
		'WholeSaleQty',
		'RetailUnit',
		'RetailSaleQty'
		];
}