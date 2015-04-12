<?php namespace Acme\Repos\VwInventorySource;

use Acme\Repos\DbRepository;
use VwInventorySource;
use vwinventorybystockcard;
class DbVwInventorySource extends DbRepository implements VwInventorySourceRepository{
	protected $model;
	public function __construct(VwInventorySource $model){
		$this->model = $model;
	}
	public function getInventorySourceWholeSale($branchNo){
		return VwInventorySource::selectRaw('ProductNo, ProductName, BrandName, WholeSaleUnit As Unit, 
			    LotNo, ExpiryDate, SellingPrice As UnitPrice, Sum(WholeSaleQty) Qty, Sum(RetailSaleQty) RQty')
				->where('BranchNo','=',$branchNo)
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
	public function getInventorySourceForST($branchNo){
		return VwInventorySource::selectRaw('ProductNo, ProductName, BrandName, WholeSaleUnit As Unit, 
			    LotNo, ExpiryDate, CostPerQty As UnitPrice, Sum(WholeSaleQty) Qty')
				->where('BranchNo','=',$branchNo)
				->groupBy('ProductNo', 'ProductName', 'BrandName', 'WholeSaleUnit', 'LotNo', 'ExpiryDate', 'CostPerQty')
				->get();
	}
	public function productInventorySummary(){
		return VwInventorySource::selectRaw('BranchNo, BranchName, ProductNo, ProductName,BrandName, WholeSaleUnit,  RetailUnit, 
       Sum(WholeSaleQty) WholeSaleQty, Sum(RetailSaleQty) RetailSaleQty')
				->groupBy('BranchNo', 'BranchName', 'ProductNo', 'ProductName', 'BrandName', 'WholeSaleUnit', 'RetailUnit')
				->get();
	}
	public function productInventoryByLotNo(){
		return VwInventorySource::selectRaw('BranchNo, BranchName, ProductNo, ProductName,BrandName, LotNo, ExpiryDate, WholeSaleUnit,  RetailUnit, 
       Sum(WholeSaleQty) WholeSaleQty, Sum(RetailSaleQty) RetailSaleQty')
				->groupBy('BranchNo', 'BranchName', 'ProductNo', 'ProductName', 'BrandName', 'LotNo', 'ExpiryDate','WholeSaleUnit','RetailUnit')
				->get();
	}
	public function productInventoryStockCard(){
		return VwInventorySource::selectRaw("Select SourceName, TranDate, BranchNo, BranchName, 
				       ProductNo, ProductName,BrandName, 
				       LotNo, ExpiryDate, WholeSaleUnit, 
				       Case When LTrim(RTrim(SourceName))='Bills' OR  LTrim(RTrim(SourceName))='CustomerReturns' 
				            OR  LTrim(RTrim(SourceName))='StockTransferIn' Then
				              WholeSaleQty
				           Else
				              0.00
				       End InStock,
				       Case When LTrim(RTrim(SourceName))='SI' OR LTrim(RTrim(SourceName))='SupplierReturns' 
				                 OR LTrim(RTrim(SourceName))='InvDamages' OR LTrim(RTrim(SourceName))='StockTransferOut' Then
				              WholeSaleQty
				           Else
				              0.00
				       End OutStock,  
				       Case When SourceName='InvAdjustment' Then
				             WholeSaleQty   
				          Else
				             0.00
				       End StockAdjustment            
				From vwinventorysource
				Order BY TranDate");

	}

}