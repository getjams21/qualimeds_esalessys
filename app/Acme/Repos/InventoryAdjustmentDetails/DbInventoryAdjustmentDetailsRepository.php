<?php namespace Acme\Repos\InventoryAdjustmentDetails;

use Acme\Repos\DbRepository;
use InventoryAdjustmentDetails;
class DbInventoryAdjustmentDetailsRepository extends DbRepository implements InventoryAdjustmentDetailsRepository{
	protected $model;
	public function __construct(InventoryAdjustmentDetails $model){
		$this->model = $model;
	}
	public function getAllByIA($id){
		return InventoryAdjustmentDetails::selectRaw('Inventoryadjustmentdetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'Inventoryadjustmentdetails.ProductNo')
		->where('Inventoryadjustmentdetails.InvAdjustmentNo', '=', $id)->get();
	}
}