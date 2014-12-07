<?php namespace Acme\Repos\StockTransferDetails;

use Acme\Repos\DbRepository;
use StockTransfer;
class DbStockTransferDetailsRepository extends DbRepository implements StockTransferDetailsRepository{
	protected $model;
	public function __construct(StockTransfer $model){
		$this->model = $model;
	}
	public function getAllBySO($id){
		return StockTransfer::selectRaw('StockTransferDetails.*,pc.ProductName,pc.BrandName')
			->join('products AS pc', 'pc.id', '=', 'StockTransferDetails.ProductNo')
			->where('StockTransferDetails.SalesOrderNo', '=', $id)->get();
	}
}
