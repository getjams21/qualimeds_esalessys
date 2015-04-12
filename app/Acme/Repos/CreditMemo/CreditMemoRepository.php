<?php namespace Acme\Repos\CreditMemo;

interface CreditMemoRepository{
	public function getAll();
	public function getAllWithCat();
	public function getByid($id);
}