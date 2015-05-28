<?php namespace Acme\Repos\Damages;

use Acme\Repos\DbRepository;
use Damage;
class DbDamagesRepository extends DbRepository implements DamagesRepository{
	protected $model;
	public function __construct(Damage $model){
		$this->model = $model;
	}
	public function getMaxId(){
		return Damage::max('id');;
	}
	public function getAllWithBranch(){
		return Damage::selectRaw('inventorydamages.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'inventorydamages.BranchNo')->get();
	}
	public function getByIdWithBranch($id){
		return Damage::selectRaw('inventorydamages.*,b.BranchName')->join('Branches AS b', 'b.id', '=', 'inventorydamages.BranchNo')->where('inventorydamages.id', '=', $id)->get();
	}
}