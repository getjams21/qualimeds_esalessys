<?php namespace Acme\Repos\Product;

interface ProductRepository{
	public function getAll();
	public function getAllWithCat();
	public function getByid($id);
}