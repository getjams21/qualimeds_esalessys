<?php namespace Acme\Forms;
use Laracasts\Validation\FormValidator;

class ProductForm extends FormValidator {

	protected $rules = [
		'ProductCatNo'=> 'required|numeric',
		'ProductName' => 'required', 
		'BrandName' => 'required',
		'WholeSaleUnit' => 'required',
		'RetailUnit' => 'required',
		'RetailQtyPerWholeSaleUnit' => 'required|numeric', 
		'Reorderpoint' => 'required|numeric',
		'Markup1' => 'required|numeric',
		'Markup2' => 'required|numeric',
		'Markup3' => 'required|numeric',
		'ActiveMarkup' => 'required|numeric'
		];
}