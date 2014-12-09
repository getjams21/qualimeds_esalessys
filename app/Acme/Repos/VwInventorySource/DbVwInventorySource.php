<?php namespace Acme\Repos\VwInventorySource;

use Acme\Repos\DbRepository;
use VwInventorySource;
class DbVwInventorySource extends DbRepository implements VwInventorySourceRepository{
	protected $model;
	public function __construct(VwInventorySource $model){
		$this->model = $model;
	}
	public function getInventorySourceWholeSale(){
		return VwInventorySource::selectRaw('ProductNo, ProductName, BrandName, WholeSaleUnit As Unit, 
			    LotNo, ExpiryDate, SellingPrice As UnitPrice, Sum(WholeSaleQty) Qty, Sum(RetailSaleQty) RQty')
				->groupBy('ProductNo', 'ProductName', 'BrandName', 'WholeSaleUnit', 'LotNo', 'ExpiryDate', 'SellingPrice')->get();
	}
	public function getInventorySourceRetail(){
		return VwInventorySource::selectRaw('
			vwinventorysource.ProductNo, vwinventorysource.ProductName, vwinventorysource.BrandName, 
		    vwinventorysource.RetailUnit As Unit, 
		    LotNo, ExpiryDate, (SellingPrice/RetailQtyPerWholeSaleUnit) As UnitPrice, 
		    Sum(RetailSaleQty) Qty')
		    ->join('products','vwinventorysource.productNo','=','products.id')
		    ->groupBy('vwinventorysource.ProductNo','vwinventorysource.ProductName','vwinventorysource.BrandName',
		      'vwinventorysource.RetailUnit','vwinventorysource.LotNo','vwinventorysource.ExpiryDate','vwinventorysource.SellingPrice',
		      'RetailQtyPerWholeSaleUnit')
		    ->get();
	}
}