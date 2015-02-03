<?php namespace Acme\Repos\CustomerReturnDetails;

interface CRDRepository{
	public function getAll();
	public function getByid($id);
	public function getAllByIA($id);
}