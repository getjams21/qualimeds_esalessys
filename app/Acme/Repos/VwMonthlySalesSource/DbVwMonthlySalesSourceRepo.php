<?php namespace Acme\Repos\VwMonthlySalesSource;

use Acme\Repos\DbRepository;
use VwMonthlySalesSource;
use User;

class DbVwMonthlySalesSourceRepo extends DbRepository implements VwMonthlySalesSourceRepo{
	protected $model;
	public function __construct(VwMonthlySalesSource $model){
		$this->model = $model;
	}

	public function getMonthlySalesReport($from,$to,$salesRep){
		$from = date("Y-m-d", strtotime($from));
		$to = date("Y-m-d", strtotime($to));
		// dd($salesRep);
		return VwMonthlySalesSource::where('SalesRep','=',$salesRep)->whereBetween('TransDate', array($from, $to))->get();
	}
}