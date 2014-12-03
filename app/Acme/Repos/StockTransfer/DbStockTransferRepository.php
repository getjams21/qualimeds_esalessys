<?php namespace Acme\Repos\StockTransfer;

use Acme\Repos\DbRepository;
use StockTransfer;
class DbStockTransferRepository extends DbRepository implements StockTransferRepository{
	protected $model;
	public function __construct(StockTransfer $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return StockTransfer::max('id');;
	}
	public function getAllWithCus(){
		// return StockTransfer::selectRaw('Stocktransfers.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'Salesorders.CustomerNo')->get();
	}
	public function getByIdWithCus($id){
		// return StockTransfer::selectRaw('Salesorders.*,c.CustomerName')->join('Customers AS c', 'c.id', '=', 'Salesorders.CustomerNo')->where('Salesorders.id', '=', $id)->get();
	}
}