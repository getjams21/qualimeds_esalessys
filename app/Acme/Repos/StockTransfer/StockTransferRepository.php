<?php namespace Acme\Repos\StockTransfer;

interface StockTransferRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
}