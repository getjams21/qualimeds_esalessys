<?php namespace Acme\Repos\StockTransferDetails;

use Acme\Repos\DbRepository;
use StockTransferDetails;
class DbStockTransferDetailsRepository extends DbRepository implements StockTransferDetailsRepository{
	protected $model;
	public function __construct(StockTransferDetails $model){
		$this->model = $model;
	}
	public function getAllByST($id){
		return StockTransferDetails::selectRaw('Stocktransferdetails.*,pc.ProductName,pc.BrandName')
			->join('products AS pc', 'pc.id', '=', 'Stocktransferdetails.ProductNo')
			->where('Stocktransferdetails.StockTransferNo', '=', $id)->get();
	}
}
