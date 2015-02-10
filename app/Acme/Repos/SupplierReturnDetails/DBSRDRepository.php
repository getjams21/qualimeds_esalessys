<?php namespace Acme\Repos\SupplierReturnDetails;

use Acme\Repos\DbRepository;
use SupplierReturnDetails;
class DBSRDRepository extends DbRepository implements SRDRepository{
	protected $model;
	public function __construct(SupplierReturnDetails $model){
		$this->model = $model;
	}
	public function getAllBySR($id){
		return SupplierReturnDetails::selectRaw('Supplierreturndetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'Supplierreturndetails.ProductNo')
		->where('Supplierreturndetails.CustomerReturnNo', '=', $id)->get();
	}
}