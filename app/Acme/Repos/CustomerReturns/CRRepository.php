<?php namespace Acme\Repos\CustomerReturns;

interface CRRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getByIdWithBranch($id);
}