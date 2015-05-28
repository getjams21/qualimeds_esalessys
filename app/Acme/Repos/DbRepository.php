<?php namespace Acme\Repos;
abstract class DbRepository{
	
	public function getAllActive(){
		return $this->model->where('IsActive','=','1')->get();
	}

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