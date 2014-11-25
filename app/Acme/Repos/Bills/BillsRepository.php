<?php namespace Acme\Repos\Bills;

interface BillsRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
	public function getByIdWithSup($id);
	public function getAllWithSup();
}