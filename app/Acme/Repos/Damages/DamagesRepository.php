<?php namespace Acme\Repos\Damages;

interface DamagesRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
}