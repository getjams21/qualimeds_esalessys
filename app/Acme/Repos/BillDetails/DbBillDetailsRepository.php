<?php namespace Acme\Repos\BillDetails;

use Acme\Repos\DbRepository;
use BillDetail;
class DbBillDetailsRepository extends DbRepository implements BillDetailsRepository{
	protected $model;
	public function __construct(BillDetail $model){
		$this->model = $model;
	}
	public function getAllByBill($id){
		return BillDetail::selectRaw('Billdetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit,POD.CostPerQty as Cost')
		->join('Bills AS b', 'b.id', '=', 'Billdetails.BillNo')
		->join('products AS pc', 'pc.id', '=', 'Billdetails.ProductNo')
		 // ->join('purchaseOrderDetails AS POD', 'POD.PurchaseOrderNo', '=', 'b.PurchaseOrderNo' )
		->join('purchaseOrderDetails AS POD', function($join)
		  {			
		  	$join->on('POD.PurchaseOrderNo', '=', 'b.PurchaseOrderNo');
		    $join->on('POD.ProductNo', '=', 'Billdetails.ProductNo');
		  })
		// ->where('POD.ProductNo', '=', 'Billdetails.ProductNo')
		->where('Billdetails.BillNo', '=', $id)->get();

	}
}