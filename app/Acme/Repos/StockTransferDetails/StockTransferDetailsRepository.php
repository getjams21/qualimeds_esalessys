<?php namespace Acme\Repos\StockTransferDetails;

interface StockTransferDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllBySO($id);
}