<?php namespace Acme\Repos;
use Product;
abstract class DbRepository{
	

	public function getAll(){
		return $this->model->all();
	}

	public function getByid($id){
		return $this->model->find($id);
	}
	public function addNew($input){
		return $this->model->create($input);
	}
}