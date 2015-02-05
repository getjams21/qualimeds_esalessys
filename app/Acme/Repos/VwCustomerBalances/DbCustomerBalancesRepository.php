<?php namespace Acme\Repos\VwCustomerBalances;

use Acme\Repos\DbRepository;
use VwCustomerBalance;
class DbCustomerBalancesRepository extends DbRepository implements CustomerBalancesRepository{
	protected $model;
	public function __construct(VwCustomerBalance $model){
		$this->model = $model;
	}
	public function getSumByCustomerNo($id, $branch){
		return VwCustomerBalance::selectRaw('Sum(amount) as amount')
				->where('customerno','=',$id)
				->where('BranchNo','=',$branch)
				->groupBy('customerno')->get();
	}
}