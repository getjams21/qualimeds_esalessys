<?php namespace Acme\Repos\VwMonthlySalesSource;

interface VwMonthlySalesSourceRepo{
	public function getAll();
	public function getMonthlySalesReport($from,$to,$medRep);
	// public function getMonthlySalesReport();
}