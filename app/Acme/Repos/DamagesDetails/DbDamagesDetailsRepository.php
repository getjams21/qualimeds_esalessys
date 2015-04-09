<?php namespace Acme\Repos\DamagesDetails;

use Acme\Repos\DbRepository;
use DamagesDetails;
class DbDamagesDetailsRepository extends DbRepository implements DamagesDetailsRepository{
	protected $model;
	public function __construct(DamagesDetails $model){
		$this->model = $model;
	}
	public function getAllByIA($id){
		return DamagesDetails::selectRaw('inventorydamagedetails.*,pc.ProductName,pc.BrandName,pc.RetailUnit,pc.WholeSaleUnit')->join('products AS pc', 'pc.id', '=', 'inventorydamagedetails.ProductNo')
		->where('inventorydamagedetails.InvDamagesNo', '=', $id)->get();
	}
}