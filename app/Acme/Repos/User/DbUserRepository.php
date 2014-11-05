<?php namespace Acme\Repos\User;

use Acme\Repos\DbRepository;
use User;
class DbUserRepository extends DbRepository implements UserRepository{
	protected $model;
	public function __construct(User $model){
		$this->model = $model;
	}
}