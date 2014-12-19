<?php namespace Acme\Repos\SalesInvoiceDetails;

interface SIDetailsRepository{
	public function getAll();
	public function getByid($id);
	public function getAllBySO($id);
}