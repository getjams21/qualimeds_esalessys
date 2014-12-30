<?php namespace Acme\Repos\SalesPayment;

interface SalesPaymentRepository{
	public function getAll();
	public function getByid($id);
	public function getMaxId();
}