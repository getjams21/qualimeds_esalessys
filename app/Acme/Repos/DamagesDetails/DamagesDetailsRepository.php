<?php namespace Acme\Repos\DamagesDetails;

interface DamagesDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllByIA($id);
}