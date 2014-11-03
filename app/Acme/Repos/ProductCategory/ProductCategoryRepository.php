<?php namespace Acme\Repos\ProductCategory;

interface ProductCategoryRepository{
	public function getAll();
	public function getByid($id);
	public function getCatCount($cat);
	public function getCount($cat,$id);
}